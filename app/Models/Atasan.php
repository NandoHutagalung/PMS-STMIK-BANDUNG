<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atasan extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'departemen',
    ];
}