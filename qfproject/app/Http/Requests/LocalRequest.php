<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocalRequest extends FormRequest
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
            'nombre'    => 'required|max:190|unique:locales,nombre,' . $this->route('locale'),
            'capacidad' => 'required|integer|min:1',
            'imagen'    => 'image|mimes:jpeg,bmp,png|max:2048|unique:locales,imagen,' . $this->route('locale')
        ];
    }
}