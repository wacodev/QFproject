<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->_method;
        $rules = array(
            'nombre'    => 'required|max:190',
            'capacidad' => 'required|numeric',
            'imagen'    => 'image|max:2048|mimes:jpeg, png'
        );
        if ($method != 'PUT')
        {
            $rules['nombre'] .='|unique:locales';
        }
        return $rules;
    }
}
