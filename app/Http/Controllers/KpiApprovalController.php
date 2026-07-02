<?php

namespace App\Http\Controllers;

use App\Models\KpiNilai;
use App\Models\KpiTemplate;
use Illuminate\Http\Request;

class KpiApprovalController extends Controller
{
    private function pastikanAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->pastikanAdmin();

        $templateMenunggu = KpiTemplate::with('periode', 'items')
            ->where('status', 'diajukan')
            ->latest()
            ->get();

        $nilaiMenunggu = KpiNilai::with('periode', 'items')
            ->where('status', 'Menunggu Verifikasi')
            ->latest()
            ->get();

        $riwayatTemplate = KpiTemplate::with('periode')
            ->whereIn('status', ['aktif', 'ditolak'])
            ->latest()
            ->limit(10)
            ->get();

        $riwayatNilai = KpiNilai::with('periode')
            ->whereIn('status', ['final', 'Ditolak'])
            ->latest()
            ->limit(10)
            ->get();

        return view('kpi-approval.index', compact(
            'templateMenunggu', 'nilaiMenunggu', 'riwayatTemplate', 'riwayatNilai'
        ));
    }

    // ===== Template KPI =====

    public function show($id)
    {
        $this->pastikanAdmin();

        $template = KpiTemplate::with('periode', 'items')->findOrFail($id);

        return view('kpi-approval.show', compact('template'));
    }

    public function approve($id)
    {
        $this->pastikanAdmin();

        $template = KpiTemplate::findOrFail($id);

        $template->update([
            'status' => 'aktif',
            'catatan_approval' => null,
            'disetujui_oleh' => auth()->user()->name,
            'disetujui_at' => now(),
        ]);

        return redirect()->route('kpi-approval.index')
            ->with('success', 'Template KPI "' . $template->jabatan . '" berhasil disetujui dan kini aktif.');
    }

    public function reject(Request $request, $id)
    {
        $this->pastikanAdmin();

        $request->validate(['catatan_approval' => 'required|string|max:500']);

        $template = KpiTemplate::findOrFail($id);

        $template->update([
            'status' => 'ditolak',
            'catatan_approval' => $request->catatan_approval,
            'disetujui_oleh' => auth()->user()->name,
            'disetujui_at' => now(),
        ]);

        return redirect()->route('kpi-approval.index')
            ->with('success', 'Template KPI "' . $template->jabatan . '" ditolak.');
    }

    // ===== Nilai KPI (Realisasi) =====

    public function showNilai($id)
    {
        $this->pastikanAdmin();

        $nilai = KpiNilai::with('periode', 'items')->findOrFail($id);

        return view('kpi-approval.show-nilai', compact('nilai'));
    }

    public function approveNilai($id)
    {
        $this->pastikanAdmin();

        $nilai = KpiNilai::findOrFail($id);

        $nilai->update([
            'status' => 'final',
            'catatan_approval' => null,
            'penilai' => auth()->user()->name,
        ]);

        return redirect()->route('kpi-approval.index')
            ->with('success', 'Nilai KPI ' . $nilai->pegawai_nama . ' berhasil diverifikasi.');
    }

    public function rejectNilai(Request $request, $id)
    {
        $this->pastikanAdmin();

        $request->validate(['catatan_approval' => 'required|string|max:500']);

        $nilai = KpiNilai::findOrFail($id);

        $nilai->update([
            'status' => 'Ditolak',
            'catatan_approval' => $request->catatan_approval,
            'penilai' => auth()->user()->name,
        ]);

        return redirect()->route('kpi-approval.index')
            ->with('success', 'Nilai KPI ' . $nilai->pegawai_nama . ' ditolak, menunggu revisi.');
    }
}