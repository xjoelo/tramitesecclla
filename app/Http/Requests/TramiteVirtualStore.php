<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TramiteVirtualStore extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'tipoPersona' => 'required',
      'tipoDocumentoPersona' => 'required',
      'nroDocumentoPersona' => 'required',
      'firma' => 'required',
      'idTipoDocumento' => 'required',
      'folios' => 'required',
      'asunto' => 'required',
      'fechaDocumento' => 'required',
      'emailOrigen' => "required_without:celularOrigen",
      'celularOrigen' => "required_without:emailOrigen",
      'archivo' => 'required|mimes:pdf|max:2000'
    ];
  }
  public function attributes()
  {
    return [
      'tipoPersona' => 'Tipo persona',
      'tipoDocumentoPersona' => 'Tipo documento',
      'nroDocumentoPersona' => 'Nro documento',
      'firma' => 'Nombres completos ó Razón social',
      'idTipoDocumento' => 'Tipo documento',
      'folios' => 'Nro folios',
      'asunto' => 'Asunto',
      'fechaDocumento' => 'Fecha documento',
      'emailOrigen' => "Correo electrónico",
      'celularOrigen' => "Nro celular / teléfonico",
      'archivo' => "Archivo",
    ];
  }

  public function messages()
  {
    return [
      'emailOrigen.required_without' => 'El campo :attribute es requerido.',
      'celularOrigen.required_without' => 'El campo :attribute es requerido.',
      'archivo.mimes' => 'El campo :attribute debe ser un documento PDF.',
      'archivo.max' => "El archivo es demaciado grande"
    ];
  }
}
