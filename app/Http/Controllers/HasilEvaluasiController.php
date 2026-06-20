<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;

class HasilEvaluasiController extends Controller
{
    public function index()
    {
        $evaluasis = Evaluasi::latest()->get();

        return view(
            'hasil_evaluasi.index',
            compact('evaluasis')
        );
    }
}