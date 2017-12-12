<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    protected $table = 'reservaciones';
    
    protected $fillable = [
        'user_id',
        'local_id',
        'asignatura_id',
        'actividad_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'tema',
        'tipo',
        'codigo'
    ];

    public function user()
    {
        return $this->belongsTo('qfproject\User');
    }

    public function local()
    {
        return $this->belongsTo('qfproject\Local');
    }

    public function asignatura()
    {
        return $this->belongsTo('qfproject\Asignatura');
    }

    public function actividad()
    {
        return $this->belongsTo('qfproject\Actividad');
    }
}
