<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    public function index()
    {
        $kpis = Kpi::all();

        return view('kpi.index', compact('kpis'));
    }

    public function create()
    {
        return view('kpi.create');
    }

    public function store(Request $request)
    {
        Kpi::create([
            'kode_kpi' => $request->kode_kpi,
            'nama_kpi' => $request->nama_kpi,
            'bobot' => $request->bobot,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/kpi');
    }

    public function edit($id)
    {
        $kpi = Kpi::findOrFail($id);

        return view('kpi.edit', compact('kpi'));
    }

    public function update(Request $request, $id)
    {
        $kpi = Kpi::findOrFail($id);

        $kpi->update([
            'kode_kpi' => $request->kode_kpi,
            'nama_kpi' => $request->nama_kpi,
            'bobot' => $request->bobot,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/kpi');
    }

    public function destroy($id)
    {
        Kpi::findOrFail($id)->delete();

        return redirect('/kpi');
    }
}