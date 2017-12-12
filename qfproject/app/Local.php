<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';
    
    protected $fillable = [
        'nombre',
        'capacidad',
        'imagen'
    ];

    public function reservaciones()
    {
        return $this->hasMany('qfproject\Reservacion');
    }
}
