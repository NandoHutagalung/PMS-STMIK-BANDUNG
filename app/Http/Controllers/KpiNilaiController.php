<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\KpiNilai;
use App\Models\KpiNilaiItem;
use App\Models\KpiTemplate;
use App\Models\Periode;
use Illuminate\Http\Request;

class KpiNilaiController extends Controller
{
    public function index()
    {
        $nilais = KpiNilai::with('periode')->latest()->get();

        return view('kpi-nilai.index', compact('nilais'));
    }

    public function create()
    {
        $periodes = Periode::all();
        $dosens = Dosen::all();
        $karyawans = Karyawan::all();

        return view('kpi-nilai.create', compact('periodes', 'dosens', 'karyawans'));
    }

    // Dipanggil via AJAX/GET saat memilih kategori+pegawai+periode, untuk mengambil daftar indikator dari template KPI
public function getTemplateItems(Request $request)
    {
        $base = KpiTemplate::with('items')
            ->where('periode_id', $request->periode_id)
            ->where('kategori_pegawai', $request->kategori_pegawai)
            ->where('jabatan', $request->jabatan);

        $template = null;

        // 1. Cari dulu template yang ditujukan spesifik untuk nama ini
        if ($request->filled('pegawai_nama')) {
            $template = (clone $base)->where('pegawai_nama', $request->pegawai_nama)->latest()->first();
        }

        // 2. Kalau tidak ada, pakai template umum (berlaku untuk semua jabatan yang sama)
        if (!$template) {
            $template = (clone $base)->whereNull('pegawai_nama')->latest()->first();
        }

        // 3. Fallback data lama (sebelum kolom pegawai_nama ada)
        if (!$template) {
            $template = $base->latest()->first();
        }

        if (!$template) {
            return response()->json(['items' => [], 'template_id' => null]);
        }

        return response()->json([
            'items' => $template->items,
            'template_id' => $template->id,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori_pegawai' => 'required|string',
            'pegawai_id' => 'required',
            'pegawai_nama' => 'required|string',
            'jabatan' => 'nullable|string',
            'departemen' => 'nullable|string',
            'indikator' => 'required|array|min:1',
            'target' => 'required|array',
            'bobot' => 'required|array',
            'hasil' => 'required|array',
        ]);

        $totalNilai = 0;

        $kpiNilai = KpiNilai::create([
            'periode_id' => $request->periode_id,
            'kpi_template_id' => $request->kpi_template_id,
            'kategori_pegawai' => $request->kategori_pegawai,
            'pegawai_id' => $request->pegawai_id,
            'pegawai_nama' => $request->pegawai_nama,
            'departemen' => $request->departemen,
            'jabatan' => $request->jabatan,
            'catatan' => $request->catatan,
            'status' => $request->status ?? 'draft',
            'penilai' => auth()->user()->name,
        ]);

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

        return redirect()->route('kpi-nilai.index')
            ->with('success', 'Nilai KPI berhasil disimpan');
    }

    public function show($id)
    {
        $nilai = KpiNilai::with('items', 'periode')->findOrFail($id);

        return view('kpi-nilai.show', compact('nilai'));
    }

    public function edit($id)
    {
        $nilai = KpiNilai::with('items')->findOrFail($id);
        $periodes = Periode::all();

        return view('kpi-nilai.edit', compact('nilai', 'periodes'));
    }

    public function update(Request $request, $id)
    {
        $nilai = KpiNilai::with('items')->findOrFail($id);

        $request->validate([
            'hasil' => 'required|array',
        ]);

        $totalNilai = 0;

        foreach ($nilai->items as $i => $item) {
            $hasil = (float) ($request->hasil[$i] ?? $item->hasil);
            $target = (float) $item->target;
            $bobot = (float) $item->bobot;

            $persen = $target > 0 ? min(100, ($hasil / $target) * 100) : 0;
            $kontribusi = ($persen * $bobot) / 100;
            $totalNilai += $kontribusi;

            $item->update([
                'hasil' => $hasil,
                'nilai_persen' => round($persen, 2),
                'keterangan' => $request->keterangan[$i] ?? $item->keterangan,
            ]);
        }

        $nilai->update([
            'catatan' => $request->catatan ?? $nilai->catatan,
            'status' => $request->status ?? $nilai->status,
            'total_nilai' => round($totalNilai, 2),
        ]);

        return redirect()->route('kpi-nilai.index')
            ->with('success', 'Nilai KPI berhasil diperbarui');
    }

    public function destroy($id)
    {
        KpiNilai::findOrFail($id)->delete();

        return redirect()->route('kpi-nilai.index')
            ->with('success', 'Nilai KPI berhasil dihapus');
    }

}