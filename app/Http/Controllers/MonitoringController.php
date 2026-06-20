<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Karyawan;
use App\Models\Evaluasi;
use App\Models\Capaian;
use App\Models\Feedback;

class MonitoringController extends Controller
{
    public function index()
    {
        $totalDosen = Dosen::count();
        $totalKaryawan = Karyawan::count();
        $totalEvaluasi = Evaluasi::count();
        $totalCapaian = Capaian::count();
        $totalFeedback = Feedback::count();

        $evaluasiTerbaik =
            Evaluasi::orderByDesc('nilai')
            ->take(5)
            ->get();

        $evaluasiTerendah =
            Evaluasi::orderBy('nilai')
            ->take(5)
            ->get();

        return view(
            'monitoring.index',
            compact(
                'totalDosen',
                'totalKaryawan',
                'totalEvaluasi',
                'totalCapaian',
                'totalFeedback',
                'evaluasiTerbaik',
                'evaluasiTerendah'
            )
        );
    }
}