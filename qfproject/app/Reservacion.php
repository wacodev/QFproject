<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    /**
     * ---------------------------------------------------------------------------
     * Nombre de la tabla de la base de datos relacionada a este modelo.
     *
     * @var string
     * ---------------------------------------------------------------------------
     */

    protected $table = 'reservaciones';

    /**
     * ---------------------------------------------------------------------------
     * Atributos que son asignados en masa.
     *
     * @var array
     * ---------------------------------------------------------------------------
     */

    protected $fillable = [
        'user_id',
        'local_id',
        'asignatura_id',
        'actividad_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'tema',
        'responsable',
        'tipo',
        'codigo'
    ];

    /**
     * ---------------------------------------------------------------------------
     * Relación uno a muchos inversa con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * ---------------------------------------------------------------------------
     */

    public function user()
    {
        return $this->belongsTo('qfproject\User');
    }

    /**
     * ---------------------------------------------------------------------------
     * Relación uno a muchos inversa con el modelo Local.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * ---------------------------------------------------------------------------
     */

    public function local()
    {
        return $this->belongsTo('qfproject\Local');
    }

    /**
     * ---------------------------------------------------------------------------
     * Relación uno a muchos inversa con el modelo Asignatura.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * ---------------------------------------------------------------------------
     */

    public function asignatura()
    {
        return $this->belongsTo('qfproject\Asignatura');
    }

    /**
     * ---------------------------------------------------------------------------
     * Relación uno a muchos inversa con el modelo Actividad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * ---------------------------------------------------------------------------
     */

    public function actividad()
    {
        return $this->belongsTo('qfproject\Actividad');
    }
}
