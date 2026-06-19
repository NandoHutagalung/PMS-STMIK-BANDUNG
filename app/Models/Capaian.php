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
}