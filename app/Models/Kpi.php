<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $fillable = [
        'kode_kpi',
        'nama_kpi',
        'bobot',
        'deskripsi'
    ];
}