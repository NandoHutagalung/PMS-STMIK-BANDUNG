<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiTemplate extends Model
{
protected $fillable = [
    'periode_id',
    'kategori_pegawai',
    'pegawai_id',
    'pegawai_nama',
    'unit_kerja',
    'jabatan',
    'semester',
    'status',
    'catatan_approval',
    'disetujui_oleh',
    'disetujui_at',
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