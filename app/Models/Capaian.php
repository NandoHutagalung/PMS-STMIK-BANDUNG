<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    protected $fillable = [

        'periode_id',
        'kpi_id',
        'pegawai',
        'jabatan',
        'target',
        'realisasi',
        'persentase',
        'keterangan',
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
