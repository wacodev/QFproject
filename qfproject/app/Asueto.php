<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Asueto extends Model
{
    /**
     * ---------------------------------------------------------------------------
     * Nombre de la tabla de la base de datos relacionada a este modelo.
     *
     * @var string
     * ---------------------------------------------------------------------------
     */

    protected $table = 'asuetos';

    /**
     * ---------------------------------------------------------------------------
     * Atributos que son asignados en masa.
     *
     * @var array
     * ---------------------------------------------------------------------------
     */

    protected $fillable = [
        'nombre',
        'dia',
        'mes'
    ];
}
