<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiTarget extends Model
{
    protected $fillable = [
        'periode_id', 'level', 'sasaran_strategis_id', 'kategori_pegawai',
        'nama_entitas', 'nama_target', 'target_nilai', 'satuan', 'keterangan',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function sasaranStrategis()
    {
        return $this->belongsTo(KpiMaster::class, 'sasaran_strategis_id');
    }

    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}