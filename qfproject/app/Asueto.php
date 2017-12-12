<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Asueto extends Model
{
    protected $table = 'asuetos';
    
    protected $fillable = [
        'nombre',
        'dia',
        'mes'
    ];
}
