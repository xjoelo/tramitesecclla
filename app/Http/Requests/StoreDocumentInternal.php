<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentInternal extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'idTipoDocumento' => 'required',
      'nroDocumentoTipo' => 'required',
      'archivo' => 'mimes:pdf|max:10000',
      'asunto' => 'required',
      'folios' => 'required',
      'fechaDocumento' => 'required',
    ];
  }
  public function attributes()
  {
    return [
      'idTipoDocumento' => 'Tipo de documento',
      'nroDocumentoTipo' => 'Nro documento',
      'archivo' => "Archivo",
      'folios' => 'Nro de folios',
      'asunto' => 'Asunto',
      'fechaDocumento' => 'Fecha de documento',
    ];
  }

  public function messages()
  {
    return [
      'archivo.mimes' => 'El campo :attribute debe ser un documento PDF.',
    ];
  }
}
