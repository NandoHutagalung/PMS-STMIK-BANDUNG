<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatanKaryawan = Jabatan::where('jenis', 'karyawan')->orderBy('nama_jabatan')->get();
        $jabatanDosen    = Jabatan::where('jenis', 'dosen')->orderBy('nama_jabatan')->get();

        return view('jabatan.index', compact('jabatanKaryawan', 'jabatanDosen'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan',
            'jenis'        => 'required|in:karyawan,dosen',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'jenis'        => $request->jenis,
        ]);

        return redirect('/jabatan')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);

        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan,' . $id,
            'jenis'        => 'required|in:karyawan,dosen',
        ]);

        Jabatan::findOrFail($id)->update([
            'nama_jabatan' => $request->nama_jabatan,
            'jenis'        => $request->jenis,
        ]);

        return redirect('/jabatan')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jabatan::findOrFail($id)->delete();

        return redirect('/jabatan')->with('success', 'Jabatan berhasil dihapus.');
    }
}