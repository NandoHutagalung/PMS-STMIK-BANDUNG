<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\KpiNilai;

class MonitoringController extends Controller
{
    public function index()
    {
        $totalDosen = Dosen::count();
        $totalKaryawan = Karyawan::count();

        $totalPenilaianFinal = KpiNilai::where('status', 'final')->count();
        $totalMenungguVerifikasi = KpiNilai::where('status', 'Menunggu Verifikasi')->count();

        $rataRataNilai = KpiNilai::where('status', 'final')->avg('total_nilai');

        $nilaiTerbaik = KpiNilai::where('status', 'final')
            ->whereNotNull('total_nilai')
            ->orderByDesc('total_nilai')
            ->limit(5)
            ->get();

        $nilaiTerendah = KpiNilai::where('status', 'final')
            ->whereNotNull('total_nilai')
            ->orderBy('total_nilai')
            ->limit(5)
            ->get();

        return view('monitoring.index', compact(
            'totalDosen',
            'totalKaryawan',
            'totalPenilaianFinal',
            'totalMenungguVerifikasi',
            'rataRataNilai',
            'nilaiTerbaik',
            'nilaiTerendah'
        ));
    }
}