<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $method = $this->_method;

        $rules = array(
            'name'     => 'required|max:190',
            'lastname' => 'required|max:190',
            'carnet'   => 'required|max:190',
            'email'    => 'required|max:190|email',
            'password' => 'min:6|max:190|confirmed',
            'tipo'     => 'required|max:190',
            'imagen'   => 'image|max:2048|mimes:jpeg,png',

        );

        if ($method != 'PUT') {
            $rules['carnet']   .= '|unique:users';
            $rules['email']    .= '|unique:users';
            $rules['password'] .= '|required';
            $rules['imagen']   .= '|unique:users';
        }

        return $rules;

        /*
        return [
            //
        ];
        */
    }
}
