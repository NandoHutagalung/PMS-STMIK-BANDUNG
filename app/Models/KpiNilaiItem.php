<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiNilaiItem extends Model
{
    protected $table = 'kpi_nilai_items';

    protected $fillable = [
        'kpi_nilai_id',
        'kpi_template_item_id',
        'aspek',
        'indikator',
        'target',
        'satuan',
        'bobot',
        'hasil',
        'nilai_persen',
        'keterangan',
    ];

    public function nilai()
    {
        return $this->belongsTo(KpiNilai::class, 'kpi_nilai_id');
    }
}