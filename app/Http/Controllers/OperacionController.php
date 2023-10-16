<?php

namespace App\Http\Controllers;

use App\Models\Operacion;
use App\Models\Documento;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OperacionController extends Controller
{
    public static function newDocumentRegister(Documento $documento)
    {
        $usuario = User::findOrFail($documento->idUser);
        $operacion = new Operacion;
        $operacion->idDocumento = $documento->id;
        $operacion->nroDocumento = $documento->nroDocumento;
        $operacion->idDependencia = $usuario->idDependencia;
        $operacion->nombreDependencia = $usuario->dependencia->nombre;
        $operacion->idUser = $documento->idUser;
        $operacion->nombreUsuario = $usuario->full_name;
        $operacion->fechaOperacion = new \DateTime();
        $operacion->tipoOperacion = 1;
        $operacion->forma = $documento->formaDocumento;

        $operacion->save();
        $operacion->load('documento');

        return $operacion;
    }
    public static  function derivadoVirtual(Operacion $operacion)
    {
        
        $newOperacion = new Operacion;

        $newOperacion->idDocumento = $operacion->idDocumento;
        $newOperacion->nroDocumento = $operacion->nroDocumento;
        $newOperacion->idDependencia = $operacion->idDependencia;
        $newOperacion->nombreDependencia = $operacion->nombreDependencia;
        $newOperacion->idUser = $operacion->idUser;
        $newOperacion->nombreUsuario = $operacion->nombreUsuario;
        $newOperacion->fechaOperacion = new \DateTime();
        $newOperacion->tipoOperacion = 2;
        $newOperacion->forma = $operacion->forma;
        $newOperacion->idDependenciaDestino = 3;
        $newOperacion->proveido = "PARA SU TRAMITE CORRESPONDIENTE";
        $newOperacion->idProcesado = $operacion->id;
        $newOperacion->save();

        $operacion->isProcesado = 1;
        $operacion->save();
    }
    public function derivar(Request $request)
    {
        // $documento = Documento::findOrFail($request->id);
        if($request->operacionAntes){
            $operacionAntes = Operacion::findOrFail($request->operacionAntes);
        }
        else{
            $operacionAntes = Operacion::where('idDocumento',$request->idDocumento)
                                        ->where('idDependencia',Auth::user()->idDependencia)
                                        ->where('isProcesado',0)->first();
        }  
                                   
        if($operacionAntes->tipoOperacion == 2 ){
            $operacionAntes = Operacion::where('id',$operacionAntes->idProcesado)
                                    ->where('idDependencia',Auth::user()->idDependencia)
                                    ->where('tipoOperacion',1)
                                    ->first();
        }
        $isProcesado = false;
        foreach ($request->derivaciones as $key => $value) {
            $newOperacion = new Operacion;

            $newOperacion->idDocumento = $operacionAntes->idDocumento;
            $newOperacion->nroDocumento = $operacionAntes->nroDocumento;
            $newOperacion->idDependencia = $operacionAntes->idDependencia;
            $newOperacion->nombreDependencia = $operacionAntes->nombreDependencia;
            $newOperacion->idUser = Auth::user()->id;
            $newOperacion->nombreUsuario = Auth::user()->full_name;
            $newOperacion->fechaOperacion = new \DateTime();
            $newOperacion->tipoOperacion = 2;
            $newOperacion->forma = $value['presentacionDocumento'];
            $newOperacion->idDependenciaDestino = $value['dependencia']['id'];
            if ($value['usuario']) {
                $newOperacion-> iduserDestino = $value['usuario']['id'];
            }
            
            $newOperacion->proveido = strtoupper($value['proveidoAtencion']);
            $newOperacion->idProcesado = $operacionAntes->id;
            $newOperacion->save();
            if ($value['presentacionDocumento'] == 1) {
                $isProcesado = true;
            }

        }
        if ($isProcesado) {
            $operacionAntes->isProcesado = 1;
        }

        $operacionAntes->save();

        return 1;
    }

    public function archivar(Request $request)
    {
        
        $operacionAntes = Operacion::findOrFail($request->operacionAntes);
        
        $newOperacion = new Operacion;

        $newOperacion->idDocumento = $operacionAntes->idDocumento;
        $newOperacion->nroDocumento = $operacionAntes->nroDocumento;
        $newOperacion->idDependencia = $operacionAntes->idDependencia;
        $newOperacion->nombreDependencia = $operacionAntes->nombreDependencia;
        $newOperacion->idUser = Auth::user()->id;
        $newOperacion->nombreUsuario = Auth::user()->full_name;
        $newOperacion->fechaOperacion = new \DateTime();
        $newOperacion->tipoOperacion = 3;
        $newOperacion->forma = $operacionAntes->forma;
        $newOperacion->proveido = strtoupper($request->descripcionArchivo);
        $newOperacion->idProcesado = $operacionAntes->id;
        $newOperacion->isProcesado = 1;
        $newOperacion->idArchivado = $request->idArchivador;
        $newOperacion->save();
 
        $operacionAntes->isProcesado = 1;
        $operacionAntes->save();

        return 1;
    }
    public function eliminarDerivacion(Request $request)
    {
        
        $operacion = Operacion::where('id',$request->idOperacion)
                                    ->where('idDependencia',Auth::user()->idDependencia)
                                    ->where('idUser',Auth::user()->id)
                                    ->where('tipoOperacion',2)
                                    ->where('isProcesado',0)
                                    ->firstOrFail();
        if ($operacion) {
            $documentoProcesado = $operacion->idProcesado;
            

            $isDocumentoProcesado = Operacion::where('idProcesado',$documentoProcesado)->get();
            if(!($isDocumentoProcesado->count() >= 2)){
                Operacion::where('id',$documentoProcesado)->update(['isProcesado' => 0]);
            }
        }
        $operacion->delete();
        return 1;
    }

    public function recibir(Request $request)
    {
        
        $operacionAntes = Operacion::where('id',$request->idOperacion)
                                ->where('idDependenciaDestino',Auth::user()->idDependencia)
                                ->where('tipoOperacion',2)
                                ->where('isProcesado',0)
                                ->firstOrFail();

        if ($operacionAntes){

            $newOperacion = new Operacion;

            $newOperacion->idDocumento = $operacionAntes->idDocumento;
            $newOperacion->nroDocumento = $operacionAntes->nroDocumento;
            $newOperacion->idDependencia = Auth::user()->idDependencia;
            $newOperacion->nombreDependencia = Auth::user()->dependencia->nombre;
            $newOperacion->idUser = Auth::user()->id;
            $newOperacion->nombreUsuario = Auth::user()->full_name;
            $newOperacion->fechaOperacion = new \DateTime();
            $newOperacion->tipoOperacion = 1;
            $newOperacion->forma = $operacionAntes->forma;
            $newOperacion->idProcesado = $operacionAntes->id;
            $newOperacion->isProcesado = 0;

            $newOperacion->save();

            $operacionAntes->isProcesado = 1;
            $operacionAntes->save();

        }

        return 1;
    }

    public function desarchivar(Request $request)
    {
        
        $operacionAntes = Operacion::where('id',$request->idOperacion)
                                ->where('idDependencia',Auth::user()->idDependencia)
                                ->where('tipoOperacion',3)
                                ->where('isProcesado',1)
                                ->firstOrFail();

        if ($operacionAntes){
            $fecha = date("Y-m-d H:m:s");   
            $newOperacion = new Operacion;

            $newOperacion->idDocumento = $operacionAntes->idDocumento;
            $newOperacion->nroDocumento = $operacionAntes->nroDocumento;
            $newOperacion->idDependencia = Auth::user()->idDependencia;
            $newOperacion->nombreDependencia = Auth::user()->dependencia->nombre;
            $newOperacion->idUser = Auth::user()->id;
            $newOperacion->nombreUsuario = Auth::user()->full_name;
            $newOperacion->fechaOperacion = new \DateTime();
            $newOperacion->tipoOperacion = 1;
            $newOperacion->forma = $operacionAntes->forma;
            $newOperacion->idProcesado = $operacionAntes->id;
            $newOperacion->isProcesado = 0;
            $newOperacion->proveido = "DESARCHIVADO ({$fecha})";
            $newOperacion->save();

            $operacionAntes->isDesarchivado = 1;
            $operacionAntes->fechaDesarchivado = new \DateTime();
            $operacionAntes->save();

        }

        return 1;
    }
    
    public function reporteDerivados(Request $request)
    {
        $desde    = Carbon::parse("$request->desdeFecha $request->desdeHora")->toDateTimeString();
        if (!$request->hastaHora) {
            $dt = new \DateTime();
            $horaHasta = $dt->format('H:i:s');
        }
        else{
            $horaHasta = $request->hastaHora;
        }
        $hasta      = Carbon::parse("$request->hastaFecha $horaHasta")->toDateTimeString(); 

        $documentos = Operacion::WhereBetween('fechaOperacion', [$desde, $hasta])
                                ->where('tipoOperacion',2)
                                ->where('idDependencia',Auth::user()->dependencia->id);

        $isDependencia = false;
        if($request->dependencia){
            $documentos = $documentos->where('idDependenciaDestino',$request->dependencia); 
            $isDependencia = true;  
        }
        if($request->tipoDocumento){
            $documentos = $documentos->WhereHas('documento', function ($subQuery) use ($request){
                                            $subQuery->where('idTipoDocumento', $request->tipoDocumento);
                                        });
        }
        if(!$request->showRecibidos){
            $documentos = $documentos->where('isProcesado',0);
        }
        

        $documentos = $documentos->get();

        return view('tramite.reportes.reporteDerivados',compact('documentos','desde','hasta','isDependencia'));
    }
    
    public function reportePorRecibir(Request $request)
    {
        $desde    = Carbon::parse("$request->desdeFecha $request->desdeHora")->toDateTimeString();
        $hasta      = Carbon::parse("$request->hastaFecha $request->hastaHora")->toDateTimeString(); 

        $documentos = Operacion::WhereBetween('fechaOperacion', [$desde, $hasta])
                                ->where('tipoOperacion',2)
                                ->where('isProcesado',0)
                                ->where('idDependenciaDestino',Auth::user()->dependencia->id);


        if($request->dependencia){
            $documentos = $documentos->where('idDependencia',$request->dependencia);      
        }
        if($request->tipoDocumento){
            $documentos = $documentos->WhereHas('documento', function ($subQuery) use ($request){
                                            $subQuery->where('idTipoDocumento', $request->tipoDocumento);
                                        });
        }

        $documentos = $documentos->get();
        $titulo = "DOCUMENTOS POR RECIBIR EN";
        $estado = 1;
        return view('tramite.reportes.reporteTodos',compact('documentos','desde','hasta','titulo','estado'));
    }

    public function reporteGenerados(Request $request)
    {
        $desde    = Carbon::parse("$request->desdeFecha $request->desdeHora")->toDateTimeString();
        $hasta      = Carbon::parse("$request->hastaFecha $request->hastaHora")->toDateTimeString(); 

        $documentos = Operacion::WhereBetween('fechaOperacion', [$desde, $hasta])
                                ->where('tipoOperacion',1)
                                ->whereNull('idProcesado')
                                ->where('idDependencia',Auth::user()->dependencia->id);

        if($request->usuario){
            $documentos = $documentos->where('idUser',$request->usuario);      
        }
        if($request->tipoDocumento){
            $documentos = $documentos->WhereHas('documento', function ($subQuery) use ($request){
                                            $subQuery->where('idTipoDocumento', $request->tipoDocumento);
                                        });
        }

        $documentos = $documentos->get();
        $titulo = "DOCUMENTOS GENERADOS POR";
        $estado = 2;
        return view('tramite.reportes.reporteTodos',compact('documentos','desde','hasta','titulo','estado'));
    }
    
    public function reporteRecibidos(Request $request)
    {
        $desde    = Carbon::parse("$request->desdeFecha $request->desdeHora")->toDateTimeString();
        $hasta      = Carbon::parse("$request->hastaFecha $request->hastaHora")->toDateTimeString(); 

        $documentos = Operacion::WhereBetween('fechaOperacion', [$desde, $hasta])
                                ->where('tipoOperacion',1)
                                ->whereNotNull('idProcesado')
                                ->where('isProcesado',1)
                                ->where('idDependencia',Auth::user()->dependencia->id);

        if($request->usuario){
            $documentos = $documentos->where('idUser',$request->usuario);      
        }
        if($request->tipoDocumento){
            $documentos = $documentos->WhereHas('documento', function ($subQuery) use ($request){
                                            $subQuery->where('idTipoDocumento', $request->tipoDocumento);
                                        });
        }

        $documentos = $documentos->get();
        $titulo = "DOCUMENTOS RECIBIDOS EN";
        $estado = 3;
        return view('tramite.reportes.reporteTodos',compact('documentos','desde','hasta','titulo','estado'));
    }
    public function reporteArchivados(Request $request)
    {
        $desde    = Carbon::parse("$request->desdeFecha $request->desdeHora")->toDateTimeString();
        $hasta      = Carbon::parse("$request->hastaFecha $request->hastaHora")->toDateTimeString(); 

        $documentos = Operacion::WhereBetween('fechaOperacion', [$desde, $hasta])
                                ->where('tipoOperacion',3)
                                ->whereNull('isDesarchivado')
                                ->where('isProcesado',1)
                                ->where('idDependencia',Auth::user()->dependencia->id);

        if($request->usuario){
            $documentos = $documentos->where('idUser',$request->usuario);      
        }
        if($request->tipoDocumento){
            $documentos = $documentos->WhereHas('documento', function ($subQuery) use ($request){
                                            $subQuery->where('idTipoDocumento', $request->tipoDocumento);
                                        });
        }

        $documentos = $documentos->get();
        $titulo = "DOCUMENTOS ARCHIVADOS EN";
        $estado = 3;
        return view('tramite.reportes.reporteTodos',compact('documentos','desde','hasta','titulo','estado'));
    }
    
    
    
    
}
