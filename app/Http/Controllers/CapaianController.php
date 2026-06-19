<?php

namespace App\Http\Controllers;

use App\Models\Capaian;
use App\Models\Periode;
use App\Models\Kpi;
use Illuminate\Http\Request;


class CapaianController extends Controller
{
    public function index()
    {
    $capaians = Capaian::all();

    return view(
        'capaian.index',
        compact('capaians')
    );
    }

    public function create()
    {
    $periodes = Periode::all();

    $kpis = Kpi::all();

    return view(
        'capaian.create',
        compact('periodes','kpis')
    );
    }

    public function store(Request $request)
    {
    Capaian::create([

        'periode_id' => $request->periode_id,
        'kpi_id' => $request->kpi_id,

        'pegawai' => $request->pegawai,
        'jabatan' => $request->jabatan,

        'target' => $request->target,
        'realisasi' => $request->realisasi,

        'persentase' =>
        ($request->realisasi / $request->target) * 100,

        'keterangan' => $request->keterangan,

    ]);

    return redirect('/capaian');
    }

    /**
     * Display the specified resource.
     */
    public function show(Capaian $capaian)
    {
        //
    }

    public function edit(Capaian $capaian)
    {
    $periodes = Periode::all();
    $kpis = Kpi::all();

    return view(
        'capaian.edit',
        compact('capaian','periodes','kpis')
    );
    }
    
    public function update(Request $request, Capaian $capaian)
    {
    $capaian->update([

        'periode_id' => $request->periode_id,
        'kpi_id' => $request->kpi_id,

        'pegawai' => $request->pegawai,
        'jabatan' => $request->jabatan,

        'target' => $request->target,
        'realisasi' => $request->realisasi,

        'persentase' =>
        ($request->realisasi / $request->target) * 100,

        'keterangan' => $request->keterangan,

    ]);

    return redirect('/capaian');
    }

   public function destroy(Capaian $capaian)
{
    $capaian->delete();

    return redirect('/capaian');
}
}