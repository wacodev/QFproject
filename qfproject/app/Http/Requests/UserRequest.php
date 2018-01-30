<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use qfproject\User;

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
        $user = User::find($this->route('user'));

        $rules = array(
            'name'     => 'required|max:190',
            'lastname' => 'required|max:190',
            'email'    => 'required|max:190|email|unique:users,email,' . $this->route('user'),
            'password' => 'max:190|confirmed',
            'tipo'     => 'required',
            'imagen'   => 'image|mimes:jpeg,png,bmp|max:2048'
        );

        if ($user == null) {
            $rules['password'] .= '|required|min:6';
        }

        return $rules;
    }
}
