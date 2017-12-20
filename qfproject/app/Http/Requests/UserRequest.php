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
            'name'     => 'max:190|required',
            'lastname' => 'max:190|required',
            'carnet'   => 'max:190|required',
            'email'    => 'max:190|required|email',
            'password' => 'min:6|max:190|confirmed',
            'tipo'     => 'max:190|required',
            'imagen'   => 'image|max:2048|mimes:jpeg,png',

        );
        if ($method != 'PUT')
        {
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
