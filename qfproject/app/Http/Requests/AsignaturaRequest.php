<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignaturaRequest extends FormRequest
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
            'codigo' => 'max:190|required',
            'nombre' => 'max:190|required'
        );
        if ($method != 'PUT')
        {
            $rules['codigo'] .='|unique:asignaturas';
        }
        return $rules;
        
        /*
        return [
            'codigo' => 'max:190|required|unique:asignaturas',
            'nombre' => 'max:190|required'
        ];
        */
    }
}
