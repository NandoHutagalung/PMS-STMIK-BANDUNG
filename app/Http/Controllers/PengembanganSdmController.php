<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\PengembanganSdm;
use Illuminate\Http\Request;

class PengembanganSdmController extends Controller
{
    private function pastikanKaryawan()
    {
        if (auth()->user()->role !== 'karyawan') {
            abort(403);
        }
    }

    public function index()
    {
        $this->pastikanKaryawan();

        $user = auth()->user();

        $kegiatans = PengembanganSdm::where('karyawan_nama', $user->name)
            ->latest()
            ->get();

        $rekap = [
            'Pelatihan' => $kegiatans->where('kategori', 'Pelatihan')->count(),
            'Sertifikasi' => $kegiatans->where('kategori', 'Sertifikasi')->count(),
            'Penghargaan' => $kegiatans->where('kategori', 'Penghargaan')->count(),
        ];

        return view('pengembangan-sdm.index', compact('kegiatans', 'rekap'));
    }

    public function create(Request $request)
    {
        $this->pastikanKaryawan();

        $kategoriTerpilih = $request->query('kategori', 'Pelatihan');

        return view('pengembangan-sdm.create', compact('kategoriTerpilih'));
    }

    public function store(Request $request)
    {
        $this->pastikanKaryawan();

        $request->validate([
            'kategori' => 'required|in:Pelatihan,Sertifikasi,Penghargaan',
            'judul' => 'required|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'keterangan_bukti' => 'nullable|string',
        ]);

        $user = auth()->user();
        $karyawan = Karyawan::where('nama', $user->name)->first();

        PengembanganSdm::create([
            'karyawan_id' => $karyawan?->id,
            'karyawan_nama' => $user->name,
            'kategori' => $request->kategori,
            'judul' => $request->judul,
            'penyelenggara' => $request->penyelenggara,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'nomor_sertifikat' => $request->nomor_sertifikat,
            'deskripsi' => $request->deskripsi,
            'keterangan_bukti' => $request->keterangan_bukti,
        ]);

        return redirect()->route('pengembangan-sdm.index')
            ->with('success', 'Data Pengembangan SDM berhasil ditambahkan');
    }

    public function edit($id)
    {
        $this->pastikanKaryawan();

        $kegiatan = PengembanganSdm::where('karyawan_nama', auth()->user()->name)->findOrFail($id);

        return view('pengembangan-sdm.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $this->pastikanKaryawan();

        $kegiatan = PengembanganSdm::where('karyawan_nama', auth()->user()->name)->findOrFail($id);

        $request->validate([
            'kategori' => 'required|in:Pelatihan,Sertifikasi,Penghargaan',
            'judul' => 'required|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'keterangan_bukti' => 'nullable|string',
        ]);

        $kegiatan->update($request->only([
            'kategori', 'judul', 'penyelenggara', 'tanggal_mulai',
            'tanggal_selesai', 'nomor_sertifikat', 'deskripsi', 'keterangan_bukti',
        ]));

        return redirect()->route('pengembangan-sdm.index')
            ->with('success', 'Data Pengembangan SDM berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->pastikanKaryawan();

        PengembanganSdm::where('karyawan_nama', auth()->user()->name)->findOrFail($id)->delete();

        return redirect()->route('pengembangan-sdm.index')
            ->with('success', 'Data Pengembangan SDM berhasil dihapus');
    }
}