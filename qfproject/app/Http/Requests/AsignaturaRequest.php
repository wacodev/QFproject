<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignaturaRequest extends FormRequest
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
            'codigo' => 'required|max:190|unique:asignaturas,codigo,' . $this->route('asignatura'),
            'nombre' => 'required|max:190'
        ];
    }
}
