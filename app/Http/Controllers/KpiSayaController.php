<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
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
        return auth()->user()->role === 'dosen' ? 'Dosen' : 'Pegawai';
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

public function grafik()
    {
        $user = auth()->user();
        $kategori = $this->kategoriUser();

        $riwayat = KpiNilai::with(['periode', 'items'])
            ->where('kategori_pegawai', $kategori)
            ->where('pegawai_nama', $user->name)
            ->whereIn('status', ['final', 'Menunggu Verifikasi'])
            ->get()
            ->sortBy(function ($item) {
                return $item->periode?->tahun . '-' . $item->periode?->nama_periode;
            })
            ->values();

        $labelPeriode = $riwayat->map(function ($item) {
            return $item->periode
                ? $item->periode->nama_periode . ' ' . $item->periode->tahun
                : '-';
        });

        $nilaiPeriode = $riwayat->pluck('total_nilai');

        $rataRata = $nilaiPeriode->count() ? round($nilaiPeriode->avg(), 2) : 0;
        $tertinggi = $nilaiPeriode->count() ? round($nilaiPeriode->max(), 2) : 0;
        $terendah = $nilaiPeriode->count() ? round($nilaiPeriode->min(), 2) : 0;

        // Collection dengan key = nama indikator, value = rata-rata nilai_persen
        $rataPerIndikator = $riwayat
            ->flatMap(function ($item) {
                return $item->items;
            })
            ->groupBy('indikator')
            ->map(function ($items) {
                return round($items->avg('nilai_persen'), 2);
            });

        return view('kpi-saya.grafik', compact(
            'riwayat', 'rataRata', 'tertinggi', 'terendah',
            'labelPeriode', 'nilaiPeriode', 'rataPerIndikator'
        ));
    }

    public function show($id)
    {
        $user = auth()->user();

        $nilai = KpiNilai::with('items', 'periode')
            ->where('pegawai_nama', $user->name)
            ->findOrFail($id);

        return view('kpi-saya.show', compact('nilai'));
    }

    public function inputForm()
    {
        $user = auth()->user();
        $kategori = $this->kategoriUser();

        if ($kategori === 'Dosen') {
            $entitas = Dosen::where('nama', $user->name)->first();
        } else {
            $entitas = Karyawan::where('nama', $user->name)->first();
        }

        $periodes = Periode::all();

        return view('kpi-saya.input', compact('periodes', 'entitas', 'kategori'));
    }

    public function getMyExisting(Request $request)
    {
        $user = auth()->user();

        $existing = KpiNilai::with('items')
            ->where('periode_id', $request->periode_id)
            ->where('kategori_pegawai', $this->kategoriUser())
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
        $user = auth()->user();
        $kategori = $this->kategoriUser();

        if ($kategori === 'Dosen') {
            $entitas = Dosen::where('nama', $user->name)->first();
        } else {
            $entitas = Karyawan::where('nama', $user->name)->first();
        }

        abort_if(!$entitas, 404, 'Data ' . $kategori . ' untuk akun ini tidak ditemukan. Hubungi admin.');

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'indikator'  => 'required|array|min:1',
            'target'     => 'required|array',
            'bobot'      => 'required|array',
            'hasil'      => 'required|array',
        ]);

        $existing = KpiNilai::where('periode_id', $request->periode_id)
            ->where('kategori_pegawai', $kategori)
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
            $kpiNilai                    = new KpiNilai();
            $kpiNilai->periode_id        = $request->periode_id;
            $kpiNilai->kpi_template_id   = $request->kpi_template_id;
            $kpiNilai->kategori_pegawai  = $kategori;
            $kpiNilai->pegawai_id        = $entitas->id;
            $kpiNilai->pegawai_nama      = $user->name;
            $kpiNilai->departemen        = $kategori === 'Dosen'
                ? ($entitas->program_studi ?? null)
                : ($entitas->departemen ?? null);
            $kpiNilai->jabatan           = $entitas->jabatan;
        }

        $kpiNilai->catatan = $request->catatan;
        $kpiNilai->status  = 'Menunggu Verifikasi';
        $kpiNilai->penilai = null;
        $kpiNilai->save();

        foreach ($request->indikator as $i => $indikator) {
            $target = (float) ($request->target[$i] ?? 0);
            $hasil  = (float) ($request->hasil[$i] ?? 0);
            $bobot  = (float) ($request->bobot[$i] ?? 0);

            $persen     = $target > 0 ? min(100, ($hasil / $target) * 100) : 0;
            $kontribusi = ($persen * $bobot) / 100;
            $totalNilai += $kontribusi;

            KpiNilaiItem::create([
                'kpi_nilai_id' => $kpiNilai->id,
                'aspek'        => $request->aspek[$i] ?? null,
                'indikator'    => $indikator,
                'target'       => $target,
                'satuan'       => $request->satuan[$i] ?? null,
                'bobot'        => $bobot,
                'hasil'        => $hasil,
                'nilai_persen' => round($persen, 2),
                'keterangan'   => $request->keterangan[$i] ?? null,
            ]);
        }

        $kpiNilai->update(['total_nilai' => round($totalNilai, 2)]);

        return redirect()->route('kpi-saya.index')
            ->with('success', 'Realisasi KPI berhasil disimpan dan menunggu verifikasi admin.');
    }
}