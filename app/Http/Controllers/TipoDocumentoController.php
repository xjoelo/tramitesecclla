<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoDocumentoStore;
use App\Http\Requests\TipoDocumentoUpdate;
use App\Models\NumeracionTipoDocumento;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;


use App\Http\Controllers\NumeracionTipoDocumentoController;


class TipoDocumentoController extends Controller
{
  public function list(Request $request)
  {
    $where = [];
    if ($request->searchBy && $request->inputSearch) {
      $where[] = [$request->searchBy, 'LIKE', "%$request->inputSearch%"];
    }
    $listTypeDocuments = TipoDocumento::where($where)->paginate($request->paginate);
    return $listTypeDocuments;
  }

  public function insert(TipoDocumentoStore $request)
  {
    $tipoDocumento = new TipoDocumento;
    $tipoDocumento->nombre = $request->nombre;
    $tipoDocumento->abreviado = $request->abreviado;
    $tipoDocumento->save();

    return $tipoDocumento;
  }

  public function update(TipoDocumentoUpdate $request)
  {
    $tipoDocumento = TipoDocumento::find($request->id);
    $tipoDocumento->nombre = $request->nombre;
    $tipoDocumento->abreviado = $request->abreviado;
    $tipoDocumento->save();

    return $tipoDocumento;
  }

  public function getNumeracionTipoDocumento(Request $request)
  {
    // $filters = [];
    // $filters[] = ['idTipoDocumento','=',$request->idTipoDocumento];
    // $filters[] = ['idDependencia','=',$request->idDependencia];
    // $filters[] = ['periodo','=',$request->periodo];
    // if ($request->idUsuario > 0) {
    //   $filters[] = ['idUsuario','=', $request->idUsuario];
    // }
      
    // $data = NumeracionTipoDocumento::where($filters)->firstOrFail();
    $personal = 0;
    if ($request->isPersonal == 'personal') {
      $personal = 1;
    }

    $data = NumeracionTipoDocumentoController::getNumberDocument($request->idTipoDocumento,$request->idDependencia,$personal,$request->idUsuario);

    return $data;
  }
}
