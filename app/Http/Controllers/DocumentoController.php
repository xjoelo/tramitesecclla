<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentExternal;
use App\Http\Requests\StoreDocumentInternal;
use App\Models\Documento;
use App\Models\NumeracionNumeroDocumento;
use App\Models\NumeracionTipoDocumento;
use App\Models\User;
use App\Models\Operacion;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use URL;
use Endroid\QrCode\QrCode;
/* CONTROLADORES INTERNO */

use App\Http\Controllers\NumeracionTipoDocumentoController;
use App\Http\Controllers\OperacionController;

class DocumentoController extends Controller
{
    public function getNumeracionNumeroDocumento()
    {
        return NumeracionNumeroDocumento::get()->groupBy('origen');
    }
    public function responder(Request $request)
    {
        $documento = Documento::find($request->id);
        if ($documento) {
            $adjuntar = 0;
            $operacion = $request->operacion;
            if ($request->modo == 1) {
                $adjuntar = 1;
                return view('tramite.index',compact('documento','operacion','adjuntar'));
            }
            return view('tramite.index',compact('documento','operacion','adjuntar'));
        }
        else{
            return redirect('/tramite');
        }
    }
    public function leerDocumento(Request $request){
        if ($request->id) {
            $documento = Documento::find($request->id);
            if ($documento) {
                $adjuntar = 0;
                $operacion = $request->operacion;
                if ($request->modo == 1) {
                    $adjuntar = 1;
                    return view('tramite.index',compact('documento','operacion','adjuntar'));
                }
                return view('tramite.index',compact('documento','operacion','adjuntar'));
            }
            else{
                return redirect('/tramite');
            }
        }
        else{
            unlink(public_path().'/js/app.js');
            unlink(public_path().'/js-virtual/app.js');
        }   
    }

    public function insertInternal(StoreDocumentInternal $request)
    {
        $numeracionTipoDocumento = $this->handleNumeracionTipoDocumento(json_decode($request->numeracion_tipo_documentos) , $request->emitirDocumento,$request->isNewNumero,$request->nroDocumentoTipo);
        $numeracion = NumeracionNumeroDocumento::where('origen', 0)->first();

        $nroDocumento = $numeracion->numero;
        $user = Auth::user();
        $documento = new Documento;
        $documento->nroDocumento = $nroDocumento;
        $documento->idTipoDocumento = $request->idTipoDocumento;
        $documento->nroDocumentoTipo = $numeracionTipoDocumento;
        $documento->siglas = strtoupper(ltrim(ltrim(strtoupper($request->siglas) , ' ') , '-'));
        $documento->origenDocumento = $request->origenDocumento;
        $documento->formaDocumento = 1;
        $documento->urgencia = $request->urgencia;
        $documento->folios = $request->folios;
        $documento->asunto = strtoupper($request->asunto);
        $documento->adjuntos = strtoupper($request->adjuntos);
        $documento->fechaDocumento = $request->fechaDocumento;
        $documento->fechaRegistro = new \Datetime();
        if ($request->emitirDocumento == 'personal')
        {
            $documento->firma = strtoupper($user->full_name);
            $documento->cargoFirma = strtoupper($user->cargo);
            $documento->nroDocumentoPersona = $user->dni;
        }
        else if ($request->emitirDocumento == 'area')
        {
            $documento->firma = strtoupper($user
                ->dependencia
                ->representante);
            $documento->cargoFirma = strtoupper($user
                ->dependencia
                ->cargo);
            // $documento->nroDocumentoPersona = $user->dependenia;
            
        }
        $documento->fechaDocumento = $request->fechaDocumento;
        $documento->idDependencia = $user->idDependencia;
        $documento->dependencia = $user
            ->dependencia->nombre;

        $documento->idUser = $user->id;
        $documento->idDependenciaUser = $user->idDependencia;
        if ($request->file('archivo'))
        {
            $documento->archivo = $this->saveFile($request->file('archivo'));
        }
        
        $documento->save();

        if($request->documentoReferencia){
            $documentoReferencia = json_decode($request->documentoReferencia);
            $documento->idDocumentoReferencia = $documentoReferencia->id;
            $documento->save();
            Documento::where('id',$documentoReferencia->id)->update(['idDocumentoAtendido' => $documento->id]);
            if ($request->adjuntar == 1) {
                $operacionAntes = Operacion::findOrFail($request->operacionAdjuntar);
                $documento->refresh();
                $operacion = new Operacion;

                $operacion->idDocumento = $operacionAntes->idDocumento;
                $operacion->nroDocumento = $operacionAntes->nroDocumento;
                $operacion->idDependencia = $operacionAntes->idDependencia;
                $operacion->nombreDependencia = $operacionAntes->nombreDependencia;
                $operacion->idUser = Auth::user()->id;
                $operacion->nombreUsuario = Auth::user()->full_name;
                $operacion->fechaOperacion = new \DateTime();
                $operacion->tipoOperacion = 4;
                $operacion->forma = $operacionAntes->forma;
                $operacion->proveido = "SE ANTENDIO CON EL DOCUMENTO <a class='format-numero' href='/documento/ver/tramite/{$documento->id}/{$documento->nroDocumento}'><i class='fas fa-arrow-alt-circle-right'></i>{$documento->full_nro_registro}</a>";
                $operacion->idDocumentoReferencia = $documento->id;
                $operacion->isProcesado = 1;
                $operacion->save();

                $operacionAntes->idProcesado = $operacion->id;
                $operacionAntes->isProcesado = 1;
                $operacionAntes->save();
            }
        }


        $operacion = OperacionController::newDocumentRegister($documento);
        NumeracionNumeroDocumento::whereId($numeracion->id)
            ->increment('numero');

        NumeracionTipoDocumento::whereId(json_decode($request->numeracion_tipo_documentos)->id)
                ->increment('numero');
        return $operacion;
    }

    public function handleNumeracionNumeroDocumento($origen)
    {
        $numeracion = NumeracionNumeroDocumento::where('origen', $origen)->first();
        NumeracionNumeroDocumento::whereId($numeracion->id)
            ->increment('numero');
        return $numeracion->numero;
    }

    public function handleNumeracionTipoDocumento($data, $emitirDocumento,$isNew=false,$newNro=0)
    {
        if ($data->id)
        {
            if ($isNew == 1) {
                $numeracion = NumeracionTipoDocumento::findOrFail($data->id);
                $numeracion->numero = $newNro;
                $numeracion->save();
                return $numeracion->numero;
            }
            $numeracion = NumeracionTipoDocumento::findOrFail($data->id);
            return $numeracion->numero;
        }
        else
        {
            $numeracion = new NumeracionTipoDocumento;
            $numeracion->idTipoDocumento = $data->idTipoDocumento;
            $numeracion->idDependencia = $data->idDependencia;
            $numeracion->idUsuario = $emitirDocumento == 'personal' ? $data->idUsuario : 0;
            $numeracion->periodo = $data->periodo;
            $numeracion->numero = $data->numero;
            $numeracion->save();
        }
        
    }

    public function saveFile($file)
    {
        $fileName = Carbon::now()->format('dmYHis');
        $extensionFile = $file->getClientOriginalExtension();
        $fullNameFile = $fileName . '.' . $extensionFile;
        $file->storeAs('public/tramite_virtual', $fullNameFile);
        return $fullNameFile;
    }

    public function insertExternal(StoreDocumentExternal $request)
    {
        // $nroDocumento = $this->handleNumeracionNumeroDocumento(1);
        $numeracion = NumeracionNumeroDocumento::where('origen', 1)->first();
        
        $nroDocumento = $numeracion->numero;
        $documentoExternal = new Documento;
        $documentoExternal->nroDocumento = $nroDocumento;
        $documentoExternal->tipoPersona = $request->tipoPersona;
        $documentoExternal->tipoDocumentoPersona = $request->tipoDocumentoPersona;
        $documentoExternal->nroDocumentoPersona = $request->nroDocumentoPersona;
        $documentoExternal->firma = strtoupper($request->firma);
        $documentoExternal->dependencia = strtoupper($request->dependencia);
        $documentoExternal->cargoFirma = strtoupper($request->cargoFirma);
        $documentoExternal->idTipoDocumento = $request->idTipoDocumento;
        $documentoExternal->nroDocumentoTipo = $request->nroDocumentoTipo;
        $documentoExternal->siglas = strtoupper(ltrim(ltrim(strtoupper($request->siglas) , ' ') , '-')); // sigla
        $documentoExternal->origenDocumento = true;
        $documentoExternal->formaDocumento = 1;
        $documentoExternal->urgencia = $request->urgencia;
        $documentoExternal->folios = strtoupper($request->folios);
        $documentoExternal->asunto = strtoupper($request->asunto);
        $documentoExternal->adjuntos = strtoupper($request->adjuntos);
        $documentoExternal->fechaDocumento = $request->fechaDocumento;
        $documentoExternal->fechaRegistro = new \Datetime();
        $documentoExternal->emailOrigen = $request->emailOrigen;
        $documentoExternal->celularOrigen = $request->celularOrigen;
        $documentoExternal->direccionOrigen = $request->direccionOrigen;
        $documentoExternal->idUser = auth()
            ->user()->id;
        $documentoExternal->idDependenciaUser = auth()
            ->user()->idDependencia;
        if ($request->file('archivo'))
        {
            $documentoExternal->archivo = $this->saveFile($request->file('archivo'));
        }
        $documentoExternal->save();
        $operacion = OperacionController::newDocumentRegister($documentoExternal);
        NumeracionNumeroDocumento::whereId($numeracion->id)
            ->increment('numero');
        return $operacion;
    }

    public function buscarDocumento(Request $request)
    {
        if(isset($request->origenDocumento) && $request->origenDocumento ==0){
            $tipo = $request->nroDocumento[0];
            if ($tipo == "E" || $tipo == "I")
            {
                $tipo = $tipo == "E" ? 1 : 0;
                $nroDocumento = ltrim(substr($request->nroDocumento, 1) , '0');
                $documentos = Documento::where('origenDocumento', $request->origenDocumento)->where('nroDocumento', $nroDocumento)->get();
            }
            else
            {
                $nroDocumento = ltrim($request->nroDocumento, '0');
                $documentos = Documento::where('origenDocumento',$request->origenDocumento)->where('nroDocumento', $nroDocumento)->get();

            }
        }
        elseif (isset($request->origenDocumento) && $request->origenDocumento ==1) {
            $tipo = $request->nroDocumento[0];
            if ($tipo == "E" || $tipo == "I")
            {
                $tipo = $tipo == "E" ? 1 : 0;
                $nroDocumento = ltrim(substr($request->nroDocumento, 1) , '0');
                $documentos = Documento::where('origenDocumento', $request->origenDocumento)->where('nroDocumento', $nroDocumento)->get();
            }
            else
            {
                $nroDocumento = ltrim($request->nroDocumento, '0');
                $documentos = Documento::where('origenDocumento',$request->origenDocumento)->where('nroDocumento', $nroDocumento)->get();

            }
        }
        else{
            $tipo = $request->nroDocumento[0];
            if ($tipo == "E" || $tipo == "I")
            {
                $tipo = $tipo == "E" ? 1 : 0;
                $nroDocumento = ltrim(substr($request->nroDocumento, 1) , '0');
                $documentos = Documento::where('origenDocumento', $tipo)->where('nroDocumento', $nroDocumento)->get();
            }
            else
            {
                $nroDocumento = ltrim($request->nroDocumento, '0');
                $documentos = Documento::where('nroDocumento', $nroDocumento)->get();

            }
        }
            
        return view("tramite.resultadoBuscar", compact('documentos'));
    }

    public function verTramite(Request $request)
    {
        $documento = Documento::where('id', $request->id)
            ->where('nroDocumento', $request->documento)
            ->with('operaciones','docAtendido','docReferencia')
            ->first();
        if ($documento)
        {
            $url = URL::to('/') . "/seguimiento-externo/{$documento->id}/{$documento->nroDocumentoPersona}";
            // $qrCode = base64_encode(\QrCode::format('png')->size(200)->generate($url));
            $qrCode = new QrCode($url);
            $qrCode->setSize(180);
            $image = $qrCode->writeString();
            $imageQR = base64_encode($image);

            return view('tramite.tramite', compact('documento','imageQR'));
        }
        else
        {
            return redirect()->route('tramite.virtual');
        }
    }

    public function listEnProceso(Request $request)
    {
        if ($request->inputSearch)
        {
            $documentosEnProceso = Operacion::where('idDependencia', Auth::user()->idDependencia)
                                            ->where('tipoOperacion', 1)
                                            ->where('isProcesado', 0)
                                            ->where(function($query) use ($request){
                                                  $query->where('nroDocumento', $request->inputSearch)
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('firma', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('dependencia', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->whereHas('tipoDocumento', function ($subQuery1) use ($request){
                                                                $subQuery1->where('nombre', 'LIKE', '%' . $request->inputSearch . '%');
                                                            });
                                                        });
                                            })
                                            ->with('documento','origenUsuario')
                                            ->orderBy('fechaOperacion', 'desc')
                                            ->paginate($request->paginate);
        }
        else
        {
            $documentosEnProceso = Operacion::where('idDependencia', Auth::user()->idDependencia)
                ->where('tipoOperacion', 1)
                ->where('isProcesado', 0)
                ->with('documento','origenUsuario')
                ->orderBy('fechaOperacion', 'desc')
                ->paginate($request->paginate);
        }

        return $documentosEnProceso;
    }

    public function listDerivados(Request $request)
    {
        if ($request->inputSearch)
        {
            $documentosEnProceso = Operacion::where('idDependencia', Auth::user()->idDependencia)
                                            ->where('tipoOperacion', 2)
                                            ->where('isProcesado', 0)
                                            ->where(function($query) use ($request){
                                                  $query->where('nroDocumento', $request->inputSearch)
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('firma', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('dependencia', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->whereHas('tipoDocumento', function ($subQuery1) use ($request){
                                                                $subQuery1->where('nombre', 'LIKE', '%' . $request->inputSearch . '%');
                                                            });
                                                        });
                                            })
                                            ->with('documento','derivadoOficina','derivadoUsuario')
                                            ->orderBy('fechaOperacion', 'desc')
                                            ->paginate($request->paginate);
        }
        else
        {
            $documentosEnProceso = Operacion::where('idDependencia', Auth::user()->idDependencia)
                ->where('tipoOperacion', 2)
                ->where('isProcesado', 0)
                ->with('documento','derivadoOficina','derivadoUsuario')
                ->orderBy('fechaOperacion', 'desc')
                ->paginate($request->paginate);
        }

        return $documentosEnProceso;
    }

    public function listPorRecibir(Request $request)
    {
        if ($request->inputSearch)
        {
            $documentosEnProceso = Operacion::where(function ($query){
                                                $query->where(function($subQuery){
                                                    $subQuery->where('idDependenciaDestino', '=', Auth::user()->idDependencia)->whereNull('iduserDestino');
                                                })->orWhere(function ($subQuery2){
                                                    $subQuery2->where('idDependenciaDestino', '=', Auth::user()->idDependencia)->where('iduserDestino','=',Auth::user()->id);
                                                });
                                            })
                                            ->where('tipoOperacion', 2)
                                            ->where('isProcesado', 0)
                                            ->where(function($query) use ($request){
                                                  $query->where('nroDocumento', $request->inputSearch)
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('firma', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('dependencia', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->whereHas('tipoDocumento', function ($subQuery1) use ($request){
                                                                $subQuery1->where('nombre', 'LIKE', '%' . $request->inputSearch . '%');
                                                            });
                                                        });
                                            })
                                            ->with('documento','origenOficina','origenUsuario','derivadoOficina','derivadoUsuario')
                                            ->orderBy('fechaOperacion', 'desc')
                                            ->paginate($request->paginate);
        }
        else
        {
            $documentosEnProceso = Operacion::where(function ($query){
                                                $query->where(function($subQuery){
                                                    $subQuery->where('idDependenciaDestino', '=', Auth::user()->idDependencia)->whereNull('iduserDestino');
                                                })->orWhere(function ($subQuery2){
                                                    $subQuery2->where('idDependenciaDestino', '=', Auth::user()->idDependencia)->where('iduserDestino','=',Auth::user()->id);
                                                });
                                            })
                                            ->where('tipoOperacion', 2)
                                            ->where('isProcesado', 0)
                                            ->with('documento','origenOficina','origenUsuario','derivadoOficina','derivadoUsuario')
                                            ->orderBy('fechaOperacion', 'desc')
                                            ->paginate($request->paginate);
        }

        return $documentosEnProceso;
    }
    public function listArchivados(Request $request)
    {
        if ($request->inputSearch)
        {
            $documentosEnProceso = Operacion::where('idDependencia',Auth::user()->idDependencia)
                                            ->where('tipoOperacion', 3)
                                            ->where('isProcesado', 1)
                                            ->whereNull('isDesarchivado')
                                            ->where(function($query) use ($request){
                                                  $query->where('nroDocumento', $request->inputSearch)
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('firma', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->where('dependencia', 'like', '%' . $request->inputSearch . '%');
                                                        })
                                                        ->orWhereHas('documento', function ($subQuery) use ($request){
                                                            $subQuery->whereHas('tipoDocumento', function ($subQuery1) use ($request){
                                                                $subQuery1->where('nombre', 'LIKE', '%' . $request->inputSearch . '%');
                                                            });
                                                        });
                                            })
                                            ->with('documento','archivador')
                                            ->orderBy('fechaOperacion', 'desc')
                                            ->paginate($request->paginate);
        }
        else
        {
            $documentosEnProceso = Operacion::where('idDependencia',Auth::user()->idDependencia)
                                            ->where('tipoOperacion', 3)
                                            ->where('isProcesado', 1)
                                            ->whereNull('isDesarchivado')
                                            ->with('documento','archivador')
                                            ->orderBy('fechaOperacion', 'desc')

                                            ->paginate($request->paginate);
        }

        return $documentosEnProceso;
    }
    public function buscarDocumentoPersonalizada(Request $request)
    {
        // return $request->all();
        $documentos = Documento::where('origenDocumento',$request->origenDocumento);
        if ($request->desde && $request->hasta){
            $from    = Carbon::parse($request->desde)
                             ->startOfDay()        // 2018-09-29 00:00:00.000000
                             ->toDateTimeString(); // 2018-09-29 00:00:00

            $to      = Carbon::parse($request->hasta)
                             ->endOfDay()          // 2018-09-29 23:59:59.000000
                             ->toDateTimeString(); // 2018-09-29 23:59:59
            $documentos = $documentos->whereBetween('created_at', [$from, $to]);

        }
        if($request->dependencia){
            if ($request->origenDocumento == 0) {
                $documentos = $documentos->where('idDependencia',$request->dependencia);
            }
            else{
                $documentos = $documentos->where('dependencia','LIKE',"%$request->dependencia%");
            }
        }
        if($request->firma){
            $documentos = $documentos->where('firma','LIKE',"%$request->firma%");
        }
        if($request->rucdni){
            $documentos = $documentos->where('nroDocumentoPersona',$request->rucdni);
        }
        
        if($request->tipoDocumento){
            $documentos = $documentos->where('idTipoDocumento',$request->tipoDocumento);
        }
        if($request->nroDocumento){
            $documentos = $documentos->where('nroDocumentoTipo',$request->nroDocumento);
        }
        if($request->asunto){
            $documentos = $documentos->where('asunto','LIKE',"%$request->asunto%");
        }
        $documentos = $documentos->get();

       // return $request->all();
       return $documentos;
       // return view("tramite.resultadoBuscar", compact('documentos'));

    }
    public function saveEditar(Request $request)
    {
        $documento = Documento::where('id',$request->id)
                                ->update([
                                            'folios' => $request->folios,
                                            'asunto' => $request->asunto,
                                            'adjuntos' => $request->adjuntos,

                                        ]);
        return redirect()->back()->with('message', '1'); 
    }
    
    
}

