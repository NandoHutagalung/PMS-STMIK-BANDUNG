<?php

namespace App\Http\Controllers;

use App\Models\KpiTemplate;
use App\Models\KpiTemplateItem;
use App\Models\Periode;
use Illuminate\Http\Request;

class KpiTemplateController extends Controller
{
    public function index()
    {
        $templates = KpiTemplate::with('periode')->latest()->get();

        return view('kpi-template.index', compact('templates'));
    }

    public function create()
    {
        $periodes = Periode::all();

        return view('kpi-template.create', compact('periodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori_pegawai' => 'required|string',
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

        return redirect()->route('kpi-template.index')
            ->with('success', 'KPI berhasil disimpan');
    }

    public function edit($id)
    {
        $template = KpiTemplate::with('items')->findOrFail($id);
        $periodes = Periode::all();

        return view('kpi-template.edit', compact('template', 'periodes'));
    }

    public function update(Request $request, $id)
    {
        $template = KpiTemplate::findOrFail($id);

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori_pegawai' => 'required|string',
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
            'unit_kerja' => $request->unit_kerja,
            'jabatan' => $request->jabatan,
            'semester' => $request->semester,
            'status' => $request->status ?? $template->status,
        ]);

        // Ganti seluruh item lama dengan yang baru (lebih sederhana & aman untuk form dinamis)
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

        return redirect()->route('kpi-template.index')
            ->with('success', 'KPI berhasil diperbarui');
    }

    public function destroy($id)
    {
        KpiTemplate::findOrFail($id)->delete();

        return redirect()->route('kpi-template.index')
            ->with('success', 'KPI berhasil dihapus');
    }
}