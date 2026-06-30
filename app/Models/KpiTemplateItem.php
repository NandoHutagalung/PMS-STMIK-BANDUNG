<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiTemplateItem extends Model
{
    protected $fillable = [
        'kpi_template_id',
        'aspek',
        'indikator',
        'deskripsi',
        'target',
        'satuan',
        'bobot',
    ];

    public function template()
    {
        return $this->belongsTo(KpiTemplate::class, 'kpi_template_id');
    }
}