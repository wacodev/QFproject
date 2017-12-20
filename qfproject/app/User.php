<?php

namespace qfproject;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * ---------------------------------------------------------------------------
     * Atributos que son asignados en masa.
     *
     * @var array
     * ---------------------------------------------------------------------------
     */
    
    protected $fillable = [
        'name',
        'lastname',
        'carnet',
        'email',
        'password',
        'tipo',
        'imagen'
    ];

    /**
     * ---------------------------------------------------------------------------
     * Atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     * ---------------------------------------------------------------------------
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reservaciones()
    {
        return $this->hasMany('qfproject\Reservacion');
    }
}
