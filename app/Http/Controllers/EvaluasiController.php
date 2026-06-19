<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\Periode;
use App\Models\Kpi;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    public function index()
    {        $evaluasis = Evaluasi::with(['periode','kpi'])->get();

        return view('evaluasi.index', compact('evaluasis'));
    }

    public function create()
    {
        $periodes = Periode::all();
        $kpis = Kpi::all();

        return view(
            'evaluasi.create',
            compact('periodes', 'kpis')
        );
    }

    public function store(Request $request)
    {
        Evaluasi::create([
            'periode_id' => $request->periode_id,
            'kpi_id' => $request->kpi_id,
            'nama_pegawai' => $request->nama_pegawai,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
        ]);

        return redirect('/evaluasi');
    }

    public function show(Evaluasi $evaluasi)
    {
        //
    }

    public function edit($id)
    {
        $evaluasi = Evaluasi::findOrFail($id);

        $periodes = Periode::all();
        $kpis = Kpi::all();

        return view(
            'evaluasi.edit',
            compact('evaluasi', 'periodes', 'kpis')
        );
    }

    public function update(Request $request, $id)
    {
        $evaluasi = Evaluasi::findOrFail($id);

        $evaluasi->update([
            'periode_id' => $request->periode_id,
            'kpi_id' => $request->kpi_id,
            'nama_pegawai' => $request->nama_pegawai,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
        ]);

        return redirect('/evaluasi');
    }

    public function destroy($id)
    {
        Evaluasi::findOrFail($id)->delete();

        return redirect('/evaluasi');
    }
}