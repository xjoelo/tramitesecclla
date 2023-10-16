<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DependenciaUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|unique:dependencias,nombre,'.$this->id,
            'abreviado' => 'required',
            'siglas' => 'required',
            'cargo' => 'required',
            'representante' => 'required',
        ];
    }
}
