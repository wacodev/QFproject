<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    /**
     * ---------------------------------------------------------------------------
     * Nombre de la tabla de la base de datos relacionada a este modelo.
     *
     * @var string
     * ---------------------------------------------------------------------------
     */

    protected $table = 'suspensiones';

    /**
     * ---------------------------------------------------------------------------
     * Atributos que son asignados en masa.
     *
     * @var array
     * ---------------------------------------------------------------------------
     */

    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin'
    ];
}
