<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoDocumentoStore extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'nombre' => 'required|unique:tipo_documentos,nombre',
            'abreviado' => 'required|unique:tipo_documentos,abreviado'
        ];
    }
    public function attributes() {
        return [
            'nombre' => 'Nombre',
            'abreviado' => 'Abreviado'
        ];
    }
}
