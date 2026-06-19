<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\Periode;

class LaporanController extends Controller
{
    public function index()
    {
        $evaluasis = Evaluasi::all();
        $periodes = Periode::all();

        $rataRata = Evaluasi::avg('nilai');

        return view('laporan.index', compact(
            'evaluasis',
            'periodes',
            'rataRata'
        ));
    }
}