<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TriDharma extends Model
{
    protected $fillable = [
        'periode_id',
        'dosen_id',
        'dosen_nama',
        'kategori',
        'judul_kegiatan',
        'peran',
        'sks_jam',
        'tanggal_kegiatan',
        'deskripsi',
        'keterangan_bukti',
        'status',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}