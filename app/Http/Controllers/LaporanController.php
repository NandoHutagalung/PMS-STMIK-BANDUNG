<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\Periode;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
   public function index(Request $request)
{
    $periodes = Periode::all();

    $evaluasis = Evaluasi::query();

    if($request->periode_id)
    {
        $evaluasis->where(
            'periode_id',
            $request->periode_id
        );
    }

    $evaluasis = $evaluasis->get();

    $rataRata = $evaluasis->avg('nilai');

    return view(
        'laporan.index',
        compact(
            'evaluasis',
            'periodes',
            'rataRata'
        )
    );
}
}