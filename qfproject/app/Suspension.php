<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    protected $table = 'suspensiones';
    
    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin'
    ];
}
