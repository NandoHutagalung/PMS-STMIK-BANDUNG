<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\KpiNilai;
use App\Models\KpiTemplate;
use App\Models\Periode;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role !== 'admin') {
            return view('dashboard');
        }

        // ===== Ringkasan KPI =====
        $totalDosen = Dosen::count();
        $totalKaryawan = Karyawan::count();
        $totalPeriode = Periode::count();
        $totalTemplate = KpiTemplate::count();
        $totalPenilaianFinal = KpiNilai::where('status', 'final')->count();
        $totalMenungguVerifikasi = KpiNilai::where('status', 'Menunggu Verifikasi')->count();
        $rataRataNilai = KpiNilai::where('status', 'final')->avg('total_nilai');

        // ===== Grafik Kinerja: distribusi predikat =====
        $nilaiFinal = KpiNilai::where('status', 'final')->whereNotNull('total_nilai')->get();

        $distribusiPredikat = [
            'Sangat Baik' => $nilaiFinal->where('total_nilai', '>=', 85)->count(),
            'Baik' => $nilaiFinal->whereBetween('total_nilai', [70, 84.99])->count(),
            'Perlu Perbaikan' => $nilaiFinal->where('total_nilai', '<', 70)->count(),
        ];

        // ===== Grafik Kinerja: rata-rata nilai per kategori =====
        $rataRataDosen = KpiNilai::where('status', 'final')->where('kategori_pegawai', 'Dosen')->avg('total_nilai');
        $rataRataKaryawan = KpiNilai::where('status', 'final')->where('kategori_pegawai', 'Karyawan')->avg('total_nilai');

        // ===== Notifikasi =====
        $templateMenunggu = KpiTemplate::with('periode')
            ->where('status', 'diajukan')
            ->latest()
            ->limit(5)
            ->get();

        $nilaiMenunggu = KpiNilai::with('periode')
            ->where('status', 'Menunggu Verifikasi')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalDosen',
            'totalKaryawan',
            'totalPeriode',
            'totalTemplate',
            'totalPenilaianFinal',
            'totalMenungguVerifikasi',
            'rataRataNilai',
            'distribusiPredikat',
            'rataRataDosen',
            'rataRataKaryawan',
            'templateMenunggu',
            'nilaiMenunggu'
        ));
    }
}