<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActividadRequest extends FormRequest
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
            'nombre' => 'max:190|required'
        );
        if ($method != 'PUT')
        {
            $rules['nombre'] .='|unique:actividades';
        }
        return $rules;

        /*
        return [
            'nombre' => 'max:190|required|unique:actividades'
        ];
        */
    }
}
