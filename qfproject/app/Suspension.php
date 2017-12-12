<?php

namespace qfproject;

use Illuminate\Database\Eloquent\Model;

/*
 * ---------------------------------------------------------------------------
 * Clases agregadas por el autor.
 * ---------------------------------------------------------------------------
 */

 use Carbon\Carbon;
 use Collective\Html\Eloquent\FormAccesible;

class Suspension extends Model
{
    

    protected $table = 'suspensiones';
    
    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin'
    ];

    /*
    public function getFecha($value)
    {
    	return Carbon::parse($value)->format('m/d/Y');
    }
    */
    
}
