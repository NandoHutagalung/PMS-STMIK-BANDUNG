<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Periode;
use App\Models\TriDharma;
use Illuminate\Http\Request;

class TriDharmaController extends Controller
{
    private function pastikanDosen()
    {
        if (auth()->user()->role !== 'dosen') {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $this->pastikanDosen();

        $user = auth()->user();

        $kegiatans = TriDharma::with('periode')
            ->where('dosen_nama', $user->name)
            ->latest()
            ->get();

        $rekap = [
            'Pengajaran' => $kegiatans->where('kategori', 'Pengajaran')->count(),
            'Penelitian' => $kegiatans->where('kategori', 'Penelitian')->count(),
            'Pengabdian' => $kegiatans->where('kategori', 'Pengabdian')->count(),
            'Penunjang' => $kegiatans->where('kategori', 'Penunjang')->count(),
        ];

        return view('tri-dharma.index', compact('kegiatans', 'rekap'));
    }

    public function create(Request $request)
    {
        $this->pastikanDosen();

        $periodes = Periode::all();
        $kategoriTerpilih = $request->query('kategori', 'Pengajaran');

        return view('tri-dharma.create', compact('periodes', 'kategoriTerpilih'));
    }

    public function store(Request $request)
    {
        $this->pastikanDosen();

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori' => 'required|in:Pengajaran,Penelitian,Pengabdian,Penunjang',
            'judul_kegiatan' => 'required|string|max:255',
            'peran' => 'nullable|string|max:255',
            'sks_jam' => 'nullable|numeric',
            'tanggal_kegiatan' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'keterangan_bukti' => 'nullable|string',
        ]);

        $user = auth()->user();
        $dosen = Dosen::where('nama', $user->name)->first();

        TriDharma::create([
            'periode_id' => $request->periode_id,
            'dosen_id' => $dosen?->id,
            'dosen_nama' => $user->name,
            'kategori' => $request->kategori,
            'judul_kegiatan' => $request->judul_kegiatan,
            'peran' => $request->peran,
            'sks_jam' => $request->sks_jam,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'deskripsi' => $request->deskripsi,
            'keterangan_bukti' => $request->keterangan_bukti,
            'status' => 'Diajukan',
        ]);

        return redirect()->route('tri-dharma.index')
            ->with('success', 'Kegiatan Tri Dharma berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->pastikanDosen();

        $kegiatan = TriDharma::where('dosen_nama', auth()->user()->name)->findOrFail($id);
        $periodes = Periode::all();

        return view('tri-dharma.edit', compact('kegiatan', 'periodes'));
    }

    public function update(Request $request, $id)
    {
        $this->pastikanDosen();

        $kegiatan = TriDharma::where('dosen_nama', auth()->user()->name)->findOrFail($id);

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'kategori' => 'required|in:Pengajaran,Penelitian,Pengabdian,Penunjang',
            'judul_kegiatan' => 'required|string|max:255',
            'peran' => 'nullable|string|max:255',
            'sks_jam' => 'nullable|numeric',
            'tanggal_kegiatan' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'keterangan_bukti' => 'nullable|string',
        ]);

        $kegiatan->update($request->only([
            'periode_id', 'kategori', 'judul_kegiatan', 'peran',
            'sks_jam', 'tanggal_kegiatan', 'deskripsi', 'keterangan_bukti',
        ]));

        return redirect()->route('tri-dharma.index')
            ->with('success', 'Kegiatan Tri Dharma berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->pastikanDosen();

        TriDharma::where('dosen_nama', auth()->user()->name)->findOrFail($id)->delete();

        return redirect()->route('tri-dharma.index')
            ->with('success', 'Kegiatan Tri Dharma berhasil dihapus');
    }
}