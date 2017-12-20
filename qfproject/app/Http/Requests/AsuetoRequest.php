<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsuetoRequest extends FormRequest
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
        $rules = array(
            'nombre' => 'max:190|required',
            'fecha'  => ''
        );
        if ($this->route('asueto') == null)
        {
            $rules['fecha'] .= 'required';
        }
        return $rules;
    }
}
