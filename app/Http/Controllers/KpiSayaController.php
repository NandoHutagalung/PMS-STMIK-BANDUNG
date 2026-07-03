<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\KpiNilai;
use App\Models\KpiNilaiItem;
use App\Models\KpiTemplate;
use App\Models\Periode;
use Illuminate\Http\Request;

class KpiSayaController extends Controller
{
    private function kategoriUser()
    {
        return auth()->user()->role === 'dosen' ? 'Dosen' : 'Karyawan';
    }

    public function index()
    {
        $user = auth()->user();
        $kategori = $this->kategoriUser();

        $nilais = KpiNilai::with('periode')
            ->where('kategori_pegawai', $kategori)
            ->where('pegawai_nama', $user->name)
            ->latest()
            ->get();

        return view('kpi-saya.index', compact('nilais', 'kategori'));
    }

    public function show($id)
    {
        $user = auth()->user();

        $nilai = KpiNilai::with('items', 'periode')
            ->where('pegawai_nama', $user->name)
            ->findOrFail($id);

        return view('kpi-saya.show', compact('nilai'));
    }

    public function grafik()
    {
        $user = auth()->user();
        $kategori = $this->kategoriUser();

        $riwayat = KpiNilai::with('periode')
            ->where('kategori_pegawai', $kategori)
            ->where('pegawai_nama', $user->name)
            ->where('status', 'final')
            ->get()
            ->sortBy(function ($item) {
                return $item->periode->tahun ?? 0;
            })
            ->values();

        $labelPeriode = $riwayat->map(function ($item) {
            return $item->periode->nama_periode ?? '-';
        });

        $nilaiPeriode = $riwayat->pluck('total_nilai');

        $rataRata = $riwayat->avg('total_nilai');
        $tertinggi = $riwayat->max('total_nilai');
        $terendah = $riwayat->min('total_nilai');

        // Rata-rata per indikator (untuk lihat kekuatan/kelemahan)
        $rataPerIndikator = [];
        foreach ($riwayat as $nilai) {
            foreach ($nilai->items as $item) {
                $key = $item->indikator;
                if (!isset($rataPerIndikator[$key])) {
                    $rataPerIndikator[$key] = ['total' => 0, 'count' => 0];
                }
                $rataPerIndikator[$key]['total'] += $item->nilai_persen;
                $rataPerIndikator[$key]['count']++;
            }
        }
        $rataPerIndikator = collect($rataPerIndikator)->map(function ($v) {
            return round($v['total'] / $v['count'], 2);
        });

        return view('kpi-saya.grafik', compact(
            'labelPeriode', 'nilaiPeriode', 'rataRata', 'tertinggi', 'terendah', 'rataPerIndikator', 'riwayat'
        ));
    }

    public function inputForm()
    {
        if (auth()->user()->role !== 'karyawan') {
            abort(403);
        }

        $user = auth()->user();
        $karyawan = Karyawan::where('nama', $user->name)->first();
        $periodes = Periode::all();

        return view('kpi-saya.input', compact('periodes', 'karyawan'));
    }

    public function getMyExisting(Request $request)
    {
        $user = auth()->user();

        $existing = KpiNilai::with('items')
            ->where('periode_id', $request->periode_id)
            ->where('kategori_pegawai', 'Karyawan')
            ->where('pegawai_nama', $user->name)
            ->first();

        if (!$existing) {
            return response()->json(['exists' => false]);
        }

        return response()->json([
            'exists' => true,
            'status' => $existing->status,
            'catatan' => $existing->catatan,
            'items' => $existing->items,
        ]);
    }

    public function inputStore(Request $request)
    {
        if (auth()->user()->role !== 'karyawan') {
            abort(403);
        }

        $user = auth()->user();
        $karyawan = Karyawan::where('nama', $user->name)->first();

        abort_if(!$karyawan, 404, 'Data karyawan untuk akun ini tidak ditemukan. Hubungi admin.');

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'indikator' => 'required|array|min:1',
            'target' => 'required|array',
            'bobot' => 'required|array',
            'hasil' => 'required|array',
        ]);

        $existing = KpiNilai::where('periode_id', $request->periode_id)
            ->where('kategori_pegawai', 'Karyawan')
            ->where('pegawai_nama', $user->name)
            ->first();

        if ($existing && $existing->status === 'final') {
            return redirect()->back()
                ->with('error', 'Data realisasi periode ini sudah diverifikasi oleh admin dan tidak dapat diubah lagi.');
        }

        $totalNilai = 0;

        if ($existing) {
            $kpiNilai = $existing;
            $kpiNilai->items()->delete();
        } else {
            $kpiNilai = new KpiNilai();
            $kpiNilai->periode_id = $request->periode_id;
            $kpiNilai->kpi_template_id = $request->kpi_template_id;
            $kpiNilai->kategori_pegawai = 'Karyawan';
            $kpiNilai->pegawai_id = $karyawan->id;
            $kpiNilai->pegawai_nama = $user->name;
            $kpiNilai->departemen = $karyawan->departemen;
            $kpiNilai->jabatan = $karyawan->jabatan;
        }

        $kpiNilai->catatan = $request->catatan;
        $kpiNilai->status = 'Menunggu Verifikasi';
        $kpiNilai->penilai = null;
        $kpiNilai->save();

        foreach ($request->indikator as $i => $indikator) {
            $target = (float) ($request->target[$i] ?? 0);
            $hasil = (float) ($request->hasil[$i] ?? 0);
            $bobot = (float) ($request->bobot[$i] ?? 0);

            $persen = $target > 0 ? min(100, ($hasil / $target) * 100) : 0;
            $kontribusi = ($persen * $bobot) / 100;
            $totalNilai += $kontribusi;

            KpiNilaiItem::create([
                'kpi_nilai_id' => $kpiNilai->id,
                'aspek' => $request->aspek[$i] ?? null,
                'indikator' => $indikator,
                'target' => $target,
                'satuan' => $request->satuan[$i] ?? null,
                'bobot' => $bobot,
                'hasil' => $hasil,
                'nilai_persen' => round($persen, 2),
                'keterangan' => $request->keterangan[$i] ?? null,
            ]);
        }

        $kpiNilai->update(['total_nilai' => round($totalNilai, 2)]);

        return redirect()->route('kpi-saya.index')
            ->with('success', 'Realisasi KPI berhasil disimpan dan menunggu verifikasi admin.');
    }
}