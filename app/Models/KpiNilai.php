<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiNilai extends Model
{
    protected $table = 'kpi_nilai';

    protected $fillable = [
    'periode_id',
    'kpi_template_id',
    'kategori_pegawai',
    'pegawai_id',
    'pegawai_nama',
    'departemen',
    'jabatan',
    'catatan',
    'catatan_approval',
    'total_nilai',
    'status',
    'penilai',
];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function template()
    {
        return $this->belongsTo(KpiTemplate::class, 'kpi_template_id');
    }

    public function items()
    {
        return $this->hasMany(KpiNilaiItem::class, 'kpi_nilai_id');
    }

    public function getPredikatAttribute()
    {
        if ($this->total_nilai === null) {
            return '-';
        }

        if ($this->total_nilai >= 85) {
            return 'Sangat Baik';
        }

        if ($this->total_nilai >= 70) {
            return 'Baik';
        }

        return 'Perlu Perbaikan';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'final' => 'green',
            'Ditolak' => 'red',
            'Menunggu Verifikasi' => 'amber',
            default => 'gray',
        };
    }
}