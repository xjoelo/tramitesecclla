<?php

namespace App\Http\Controllers;

use App\Models\NumeracionTipoDocumento;
use Illuminate\Http\Request;
use Auth;
class NumeracionTipoDocumentoController extends Controller
{
    
    /**
    *   retorna  la numeracion del tipo del documento
    *   y si no l encuentra la crea
    */
    
    public static function selectById($id)
    {
        $numeracion = NumeracionTipoDocumento::findOrFail($id);
        return $numeracion;
    }

    public function selectByUserAuth(Request $request)
    {
        $numeracion = NumeracionTipoDocumento::Where('idTipoDocumento',$request->idTipoDocumento)
                                            ->Where('idDependencia',Auth::user()->idDependencia)
                                            ->Where('periodo',date('Y'))
                                            ->Where('isPersonal',$request->isPersonal);
        if($request->isPersonal){
            $numeracion = $numeracion->where('idUsuario',Auth::user()->id);
        }
        $numeracion = $numeracion->first();

        if(!$numeracion){
            $numeracion = self::setNumberDocument($request->idTipoDocumento,Auth::user()->idDependencia,$request->isPersonal,Auth::user()->id);
        }
        return $numeracion;
    }
    
    public static function getNumberDocument($idTipoDocumento,$idDependencia,$isPersonal,$idUsuario=false)
    {    

        $numeracion = NumeracionTipoDocumento::Where('idTipoDocumento',$idTipoDocumento)
                                                ->Where('idDependencia',$idDependencia)
                                                ->Where('periodo',date('Y'))
                                                ->where('isPersonal',$isPersonal);
        
        if($isPersonal){
            $numeracion = $numeracion->where('idUsuario',$idUsuario);
        }

        $numeracion = $numeracion->first();
        if(!$numeracion){
            $numeracion = self::setNumberDocument($idTipoDocumento,$idDependencia,$isPersonal,$idUsuario);
        }
        return $numeracion;
    }


    /**
    *   crea y retorna  la numeracion del tipo del documento
    */
    public static function setNumberDocument($idTipoDocumento,$idDependencia,$isPersonal,$idUsuario=false)
    {
        $numeracion = new NumeracionTipoDocumento;

        $numeracion->idTipoDocumento = $idTipoDocumento;
        $numeracion->idDependencia = $idDependencia;
        $numeracion->isPersonal = $isPersonal;

        if ($isPersonal) {
            $numeracion->idUsuario = $idUsuario;
        }
        $numeracion->periodo = date('Y');
        $numeracion->numero = 1;
        $numeracion->save();
        return $numeracion;
    }
    /**
    *   Incrementa en uno la numeacion
    */
    public static function incrementNumberDocument(NumeracionTipoDocumento $numeracion)
    {   
        $numeracion->numero = $numeracion->numero + 1;
        $numeracion->save();
    }
}
