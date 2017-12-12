<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
    
    protected $fillable = [
        'nombre'
    ];

    public function reservaciones()
    {
        return $this->hasMany('qfproject\Reservacion');
    }
}
