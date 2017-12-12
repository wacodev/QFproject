<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignaturas';
    
    protected $fillable = [
        'codigo',
        'nombre'
    ];

    public function reservaciones()
    {
        return $this->hasMany('qfproject\Reservacion');
    }
}
