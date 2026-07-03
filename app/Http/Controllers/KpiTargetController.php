<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\KpiMaster;
use App\Models\KpiTarget;
use App\Models\Periode;
use Illuminate\Http\Request;

class KpiTargetController extends Controller
{
    private $labelMap = [
        'individu'   => 'Individu',
        'departemen' => 'Departemen',
        'institusi'  => 'Institusi',
    ];

    private function pastikanAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    private function infoLevel($slug)
    {
        abort_if(!isset($this->labelMap[$slug]), 404);
        return $this->labelMap[$slug];
    }

    public function index($slug)
    {
        $this->pastikanAdmin();
        $level = $this->infoLevel($slug);

        $targets = KpiTarget::with('periode', 'sasaranStrategis')
            ->level($level)
            ->latest()
            ->get();

        return view('kpi-target.index', compact('targets', 'slug', 'level'));
    }

    public function create($slug)
    {
        $this->pastikanAdmin();
        $level = $this->infoLevel($slug);

        $periodes = Periode::all();
        $sasaranList = KpiMaster::tipe('sasaran_strategis')->orderBy('nama')->get();

        $daftarNama = collect();
        if ($level === 'Individu') {
            $daftarNama = Dosen::orderBy('nama')->pluck('nama')
                ->merge(Karyawan::orderBy('nama')->pluck('nama'));
        }

        $daftarDepartemen = Karyawan::whereNotNull('departemen')->distinct()->pluck('departemen');

        return view('kpi-target.create', compact('slug', 'level', 'periodes', 'sasaranList', 'daftarNama', 'daftarDepartemen'));
    }

    public function store(Request $request, $slug)
    {
        $this->pastikanAdmin();
        $level = $this->infoLevel($slug);

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'sasaran_strategis_id' => 'nullable|exists:kpi_masters,id',
            'kategori_pegawai' => 'nullable|string',
            'nama_entitas' => 'nullable|string',
            'nama_target' => 'required|string|max:255',
            'target_nilai' => 'required|numeric',
            'satuan' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        KpiTarget::create([
            'periode_id' => $request->periode_id,
            'level' => $level,
            'sasaran_strategis_id' => $request->sasaran_strategis_id,
            'kategori_pegawai' => $level === 'Individu' ? $request->kategori_pegawai : null,
            'nama_entitas' => $level === 'Institusi' ? null : $request->nama_entitas,
            'nama_target' => $request->nama_target,
            'target_nilai' => $request->target_nilai,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kpi-target.index', $slug)
            ->with('success', 'Target KPI ' . $level . ' berhasil ditambahkan');
    }

    public function edit($slug, $id)
    {
        $this->pastikanAdmin();
        $level = $this->infoLevel($slug);

        $target = KpiTarget::level($level)->findOrFail($id);
        $periodes = Periode::all();
        $sasaranList = KpiMaster::tipe('sasaran_strategis')->orderBy('nama')->get();

        $daftarNama = collect();
        if ($level === 'Individu') {
            $daftarNama = Dosen::orderBy('nama')->pluck('nama')
                ->merge(Karyawan::orderBy('nama')->pluck('nama'));
        }

        $daftarDepartemen = Karyawan::whereNotNull('departemen')->distinct()->pluck('departemen');

        return view('kpi-target.edit', compact('slug', 'level', 'target', 'periodes', 'sasaranList', 'daftarNama', 'daftarDepartemen'));
    }

    public function update(Request $request, $slug, $id)
    {
        $this->pastikanAdmin();
        $level = $this->infoLevel($slug);

        $target = KpiTarget::level($level)->findOrFail($id);

        $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'sasaran_strategis_id' => 'nullable|exists:kpi_masters,id',
            'kategori_pegawai' => 'nullable|string',
            'nama_entitas' => 'nullable|string',
            'nama_target' => 'required|string|max:255',
            'target_nilai' => 'required|numeric',
            'satuan' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $target->update([
            'periode_id' => $request->periode_id,
            'sasaran_strategis_id' => $request->sasaran_strategis_id,
            'kategori_pegawai' => $level === 'Individu' ? $request->kategori_pegawai : null,
            'nama_entitas' => $level === 'Institusi' ? null : $request->nama_entitas,
            'nama_target' => $request->nama_target,
            'target_nilai' => $request->target_nilai,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kpi-target.index', $slug)
            ->with('success', 'Target KPI ' . $level . ' berhasil diperbarui');
    }

    public function destroy($slug, $id)
    {
        $this->pastikanAdmin();
        $level = $this->infoLevel($slug);

        KpiTarget::level($level)->findOrFail($id)->delete();

        return redirect()->route('kpi-target.index', $slug)
            ->with('success', 'Target KPI ' . $level . ' berhasil dihapus');
    }
}