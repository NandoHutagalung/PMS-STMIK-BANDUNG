<?php

namespace App\Http\Controllers;

use App\Models\KpiMaster;
use Illuminate\Http\Request;

class KpiMasterController extends Controller
{
    private $labelMap = [
        'sasaran-strategis' => ['tipe' => 'sasaran_strategis', 'judul' => 'Sasaran Strategis'],
        'kategori'          => ['tipe' => 'kategori', 'judul' => 'Kategori KPI'],
        'indikator'         => ['tipe' => 'indikator', 'judul' => 'Indikator KPI'],
        'bobot'             => ['tipe' => 'bobot', 'judul' => 'Bobot KPI'],
    ];

    private function pastikanAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    private function infoTipe($slug)
    {
        abort_if(!isset($this->labelMap[$slug]), 404);
        return $this->labelMap[$slug];
    }

    public function index($tipe)
    {
        $this->pastikanAdmin();
        $info = $this->infoTipe($tipe);

        $items = KpiMaster::tipe($info['tipe'])->with('parent')->orderBy('nama')->get();

        return view('kpi-master.index', [
            'items' => $items,
            'slug' => $tipe,
            'judul' => $info['judul'],
        ]);
    }

    public function create($tipe)
    {
        $this->pastikanAdmin();
        $info = $this->infoTipe($tipe);

        $kategoriList = $info['tipe'] === 'indikator'
            ? KpiMaster::tipe('kategori')->orderBy('nama')->get()
            : collect();

        return view('kpi-master.create', [
            'slug' => $tipe,
            'judul' => $info['judul'],
            'kategoriList' => $kategoriList,
        ]);
    }

    public function store(Request $request, $tipe)
    {
        $this->pastikanAdmin();
        $info = $this->infoTipe($tipe);

        $rules = ['nama' => 'required|string|max:255', 'deskripsi' => 'nullable|string'];
        if ($info['tipe'] === 'indikator') {
            $rules['parent_id'] = 'nullable|exists:kpi_masters,id';
            $rules['satuan_default'] = 'nullable|string|max:50';
        }
        if ($info['tipe'] === 'bobot') {
            $rules['nilai'] = 'required|numeric|min:0|max:100';
        }
        $request->validate($rules);

        KpiMaster::create([
            'tipe' => $info['tipe'],
            'parent_id' => $request->parent_id,
            'nama' => $info['tipe'] === 'bobot' ? $request->nilai . '%' : $request->nama,
            'nilai' => $request->nilai,
            'satuan_default' => $request->satuan_default,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kpi-master.index', $tipe)
            ->with('success', $info['judul'] . ' berhasil ditambahkan');
    }

    public function edit($tipe, $id)
    {
        $this->pastikanAdmin();
        $info = $this->infoTipe($tipe);

        $item = KpiMaster::tipe($info['tipe'])->findOrFail($id);
        $kategoriList = $info['tipe'] === 'indikator'
            ? KpiMaster::tipe('kategori')->orderBy('nama')->get()
            : collect();

        return view('kpi-master.edit', [
            'item' => $item,
            'slug' => $tipe,
            'judul' => $info['judul'],
            'kategoriList' => $kategoriList,
        ]);
    }

    public function update(Request $request, $tipe, $id)
    {
        $this->pastikanAdmin();
        $info = $this->infoTipe($tipe);

        $item = KpiMaster::tipe($info['tipe'])->findOrFail($id);

        $rules = ['nama' => 'required|string|max:255', 'deskripsi' => 'nullable|string'];
        if ($info['tipe'] === 'indikator') {
            $rules['parent_id'] = 'nullable|exists:kpi_masters,id';
            $rules['satuan_default'] = 'nullable|string|max:50';
        }
        if ($info['tipe'] === 'bobot') {
            $rules['nilai'] = 'required|numeric|min:0|max:100';
        }
        $request->validate($rules);

        $item->update([
            'parent_id' => $request->parent_id,
            'nama' => $info['tipe'] === 'bobot' ? $request->nilai . '%' : $request->nama,
            'nilai' => $request->nilai,
            'satuan_default' => $request->satuan_default,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kpi-master.index', $tipe)
            ->with('success', $info['judul'] . ' berhasil diperbarui');
    }

    public function destroy($tipe, $id)
    {
        $this->pastikanAdmin();
        $info = $this->infoTipe($tipe);

        KpiMaster::tipe($info['tipe'])->findOrFail($id)->delete();

        return redirect()->route('kpi-master.index', $tipe)
            ->with('success', $info['judul'] . ' berhasil dihapus');
    }
}