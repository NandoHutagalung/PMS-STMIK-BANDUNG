<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiTemplate extends Model
{
    protected $fillable = [
        'periode_id',
        'kategori_pegawai',
        'unit_kerja',
        'jabatan',
        'semester',
        'status',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function items()
    {
        return $this->hasMany(KpiTemplateItem::class);
    }

    public function getTotalBobotAttribute()
    {
        return $this->items->sum('bobot');
    }
}