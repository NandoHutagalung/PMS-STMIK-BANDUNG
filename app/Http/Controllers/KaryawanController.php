<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();

        return view('karyawan.index', compact('karyawans'));
    }

public function edit($id)
{
    $karyawan = Karyawan::findOrFail($id);
    $jabatans = Jabatan::orderBy('nama_jabatan')->get();

    return view('karyawan.edit', compact('karyawan', 'jabatans'));
}
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
        ]);

        return redirect('/karyawan');
    }

    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();

        return redirect('/karyawan');
    }
}