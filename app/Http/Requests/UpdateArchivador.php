<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArchivador extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required',
            'idDependencia' => 'required',
            'periodo' => 'required',
            'isPersonal' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'idDependencia' => 'Área',
            'periodo' => 'Periodo',
            'isPersonal' => 'Es personal'
        ];
    }
}
