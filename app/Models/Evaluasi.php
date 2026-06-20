<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $fillable = [
        'periode_id',
        'kpi_id',
        'nama_pegawai',
        'nilai',
        'catatan',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function kpi()
    {
        return $this->belongsTo(Kpi::class);
    }
}