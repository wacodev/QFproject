<?php

namespace qfproject;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Illuminate\Support\Facades\Hash;
use qfproject\Notifications\MyResetPassword;

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

    /**
     * ---------------------------------------------------------------------------
     * Recibe el valor de password y si es vacío asigna el valor que tenía
     * anteriormente.
     *
     * @param  string  $value
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function setPasswordAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['password'] = Hash::make($value);
        }
    }


   

    
    public function sendPasswordResetNotification($token)
    {
    $this->notify(new MyResetPassword($token));
    }


    /**
     * ---------------------------------------------------------------------------
     * Indica si el usuario es de tipo Administrador.
     *
     * @return bool
     * ---------------------------------------------------------------------------
     */

    public function administrador()
    {
        return $this->tipo === 'Administrador';
    }

    /**
     * ---------------------------------------------------------------------------
     * Indica si el usuario es de tipo Asistente.
     *
     * @return bool
     * ---------------------------------------------------------------------------
     */

    public function asistente()
    {
        return $this->tipo === 'Asistente';
    }

    /**
     * ---------------------------------------------------------------------------
     * Indica si el usuario es de tipo Docente.
     *
     * @return bool
     * ---------------------------------------------------------------------------
     */

    public function docente()
    {
        return $this->tipo === 'Docente';
    }

    /**
     * ---------------------------------------------------------------------------
     * Indica si el usuario es de tipo Visitante.
     *
     * @return bool
     * ---------------------------------------------------------------------------
     */

    public function visitante()
    {
        return $this->tipo === 'Visitante';
    }
}
