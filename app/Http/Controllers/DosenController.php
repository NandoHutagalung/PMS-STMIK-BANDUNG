<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::all();

        return view('dosen.index', compact('dosens'));
    }


    public function show(Dosen $dosen)
    {
        //
    }

public function edit($id)
{
    $dosen = Dosen::findOrFail($id);
    $jabatans = Jabatan::orderBy('nama_jabatan')->get();

    return view('dosen.edit', compact('dosen', 'jabatans'));
}

public function update(Request $request, $id)
{
    $dosen = Dosen::findOrFail($id);

    $dosen->update([
        'nama' => $request->nama,
        'nidn' => $request->nidn,
        'jabatan' => $request->jabatan,
        'program_studi' => $request->program_studi,
    ]);

    return redirect('/dosen');
}

public function destroy($id)
{
    Dosen::findOrFail($id)->delete();

    return redirect('/dosen');
}
}