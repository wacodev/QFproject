<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Carbon\Carbon;

class SuspensionRequest extends FormRequest
{
    /**
     * ---------------------------------------------------------------------------
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     * ---------------------------------------------------------------------------
     */

    public function authorize()
    {
        return true;
    }

    /**
     * ---------------------------------------------------------------------------
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     * ---------------------------------------------------------------------------
     */

    public function rules()
    {
        return [
            'fecha'       => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
            'hora_inicio' => 'required|after_or_equal:07:00:00|before_or_equal:17:00:00',
            'hora_fin'    => 'required|after:hora_inicio|before_or_equal:18:00:00'
        ];
    }
}
