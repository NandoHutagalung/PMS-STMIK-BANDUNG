<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembanganSdm extends Model
{
    protected $table = 'pengembangan_sdms';

    protected $fillable = [
        'karyawan_id', 'karyawan_nama', 'kategori', 'judul', 'penyelenggara',
        'tanggal_mulai', 'tanggal_selesai', 'nomor_sertifikat', 'deskripsi', 'keterangan_bukti',
    ];
}