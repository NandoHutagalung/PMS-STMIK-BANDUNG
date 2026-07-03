<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiMaster extends Model
{
    protected $fillable = [
        'tipe', 'parent_id', 'nama', 'nilai', 'satuan_default', 'deskripsi',
    ];

    public function parent()
    {
        return $this->belongsTo(KpiMaster::class, 'parent_id');
    }

    public function scopeTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }
}