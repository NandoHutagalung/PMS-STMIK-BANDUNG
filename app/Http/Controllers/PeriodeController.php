<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::all();

        return view('periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        Periode::create([
            'nama_periode' => $request->nama_periode,
            'tahun' => $request->tahun,
            'status' => $request->status,
        ]);

        return redirect('/periode');
    }

    public function edit($id)
    {
        $periode = Periode::findOrFail($id);

        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $periode = Periode::findOrFail($id);

        $periode->update([
            'nama_periode' => $request->nama_periode,
            'tahun' => $request->tahun,
            'status' => $request->status,
        ]);

        return redirect('/periode');
    }

    public function destroy($id)
    {
        Periode::findOrFail($id)->delete();

        return redirect('/periode');
    }
}