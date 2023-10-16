<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoDocumentoUpdate extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'nombre' => 'required|unique:tipo_documentos,nombre,'.$this->id,
            'abreviado' => 'required|unique:tipo_documentos,abreviado,'.$this->id
        ];
    }
    public function attributes() {
        return [
            'nombre' => 'Nombre',
            'abreviado' => 'Abreviado'
        ];
    }
}
