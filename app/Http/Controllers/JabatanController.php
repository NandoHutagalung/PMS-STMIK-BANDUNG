<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();

        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan',
        ]);

        Jabatan::create(['nama_jabatan' => $request->nama_jabatan]);

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
        ]);

        Jabatan::findOrFail($id)->update(['nama_jabatan' => $request->nama_jabatan]);

        return redirect('/jabatan')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jabatan::findOrFail($id)->delete();

        return redirect('/jabatan')->with('success', 'Jabatan berhasil dihapus.');
    }
}