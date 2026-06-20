<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [

        'pemberi_feedback',
        'penerima_feedback',

        'feedback',
        'status',

    ];
}