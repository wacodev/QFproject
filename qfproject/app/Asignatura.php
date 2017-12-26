<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    /**
     * ---------------------------------------------------------------------------
     * Nombre de la tabla de la base de datos relacionada a este modelo.
     *
     * @var string
     * ---------------------------------------------------------------------------
     */

    protected $table = 'asignaturas';

    /**
     * ---------------------------------------------------------------------------
     * Atributos que son asignados en masa.
     *
     * @var array
     * ---------------------------------------------------------------------------
     */

    protected $fillable = [
        'codigo',
        'nombre'
    ];

    /**
     * ---------------------------------------------------------------------------
     * Relación uno a muchos con el modelo Reservacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * ---------------------------------------------------------------------------
     */

    public function reservaciones()
    {
        return $this->hasMany('qfproject\Reservacion');
    }
}
