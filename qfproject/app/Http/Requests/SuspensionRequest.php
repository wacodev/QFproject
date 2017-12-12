<?php

namespace qfproject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuspensionRequest extends FormRequest
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
        return [
            'fecha'       => 'date|required',
            'hora_inicio' => 'required',
            'hora_fin'    => 'required',
        ];
    }
}
