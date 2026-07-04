<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\KpiTemplate;
use App\Models\KpiTemplateItem;
use App\Models\Periode;
use Illuminate\Http\Request;

class KpiTemplateController extends Controller
{
public function index(Request $request)
    {
        $kategoriFilter = $request->query('kategori', 'Karyawan'); 

        $templates = KpiTemplate::with('periode')
            ->where('kategori_pegawai', $kategoriFilter)
            ->latest()
            ->get();

        return view('kpi-template.index', compact('templates', 'kategoriFilter'));
    }

public function create(Request $request)
    {
        $periodes = Periode::all();
        $kategoriTerpilih = $request->query('kategori', 'Karyawan');

        $daftarNama = $kategoriTerpilih == 'Dosen'
            ? Dosen::orderBy('nama')->pluck('nama')
            : Karyawan::orderBy('nama')->pluck('nama');

        return view('kpi-template.create', compact('periodes', 'kategoriTerpilih', 'daftarNama'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori_pegawai' => 'required|string',
            'pegawai_nama' => 'nullable|string',
            'unit_kerja' => 'required|string',
            'jabatan' => 'required|string',
            'semester' => 'nullable|string',
            'aspek' => 'required|array|min:1',
            'aspek.*' => 'required|string',
            'indikator' => 'required|array|min:1',
            'indikator.*' => 'required|string',
            'target' => 'required|array|min:1',
            'target.*' => 'required|numeric',
            'satuan' => 'required|array|min:1',
            'satuan.*' => 'required|string',
            'bobot' => 'required|array|min:1',
            'bobot.*' => 'required|numeric',
        ]);

        $template = KpiTemplate::create([
            'periode_id' => $request->periode_id,
            'kategori_pegawai' => $request->kategori_pegawai,
            'pegawai_nama' => $request->pegawai_nama ?: null,
            'unit_kerja' => $request->unit_kerja,
            'jabatan' => $request->jabatan,
            'semester' => $request->semester,
            'status' => $request->status ?? 'draft',
        ]);

        foreach ($request->aspek as $i => $aspek) {
            KpiTemplateItem::create([
                'kpi_template_id' => $template->id,
                'aspek' => $aspek,
                'indikator' => $request->indikator[$i] ?? '',
                'deskripsi' => $request->deskripsi[$i] ?? null,
                'target' => $request->target[$i] ?? 0,
                'satuan' => $request->satuan[$i] ?? null,
                'bobot' => $request->bobot[$i] ?? 0,
            ]);
        }

        return redirect()->route('kpi-template.index', ['kategori' => $template->kategori_pegawai])
            ->with('success', 'KPI berhasil disimpan');
    }

public function edit($id)
    {
        $template = KpiTemplate::with('items')->findOrFail($id);
        $periodes = Periode::all();

        $daftarNama = $template->kategori_pegawai == 'Dosen'
            ? Dosen::orderBy('nama')->pluck('nama')
            : Karyawan::orderBy('nama')->pluck('nama');

        return view('kpi-template.edit', compact('template', 'periodes', 'daftarNama'));
    }

    public function update(Request $request, $id)
    {
        $template = KpiTemplate::findOrFail($id);

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori_pegawai' => 'required|string',
            'pegawai_nama' => 'nullable|string',
            'unit_kerja' => 'required|string',
            'jabatan' => 'required|string',
            'semester' => 'nullable|string',
            'aspek' => 'required|array|min:1',
            'aspek.*' => 'required|string',
            'indikator' => 'required|array|min:1',
            'indikator.*' => 'required|string',
            'target' => 'required|array|min:1',
            'target.*' => 'required|numeric',
            'satuan' => 'required|array|min:1',
            'satuan.*' => 'required|string',
            'bobot' => 'required|array|min:1',
            'bobot.*' => 'required|numeric',
        ]);

        $template->update([
            'periode_id' => $request->periode_id,
            'kategori_pegawai' => $request->kategori_pegawai,
            'pegawai_nama' => $request->pegawai_nama ?: null,
            'unit_kerja' => $request->unit_kerja,
            'jabatan' => $request->jabatan,
            'semester' => $request->semester,
            'status' => $request->status ?? $template->status,
        ]);

        $template->items()->delete();

        foreach ($request->aspek as $i => $aspek) {
            KpiTemplateItem::create([
                'kpi_template_id' => $template->id,
                'aspek' => $aspek,
                'indikator' => $request->indikator[$i] ?? '',
                'deskripsi' => $request->deskripsi[$i] ?? null,
                'target' => $request->target[$i] ?? 0,
                'satuan' => $request->satuan[$i] ?? null,
                'bobot' => $request->bobot[$i] ?? 0,
            ]);
        }

        return redirect()->route('kpi-template.index', ['kategori' => $template->kategori_pegawai])
            ->with('success', 'KPI berhasil diperbarui');
    }

    public function destroy($id)
    {
        $template = KpiTemplate::findOrFail($id);
        $kategori = $template->kategori_pegawai;
        $template->delete();

        return redirect()->route('kpi-template.index', ['kategori' => $kategori])
            ->with('success', 'KPI berhasil dihapus');
    }
}