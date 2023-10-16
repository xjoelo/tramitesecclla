<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchivador;
use App\Http\Requests\UpdateArchivador;
use App\Models\Archivador;
use Illuminate\Http\Request;
use Auth;
class ArchivadorController extends Controller
{
    public function list(Request $request)
    {
        $where = [];
        if($request->searchBy && $request->searchBy != "nombreArea"  && $request->inputSearch){
            $where[] = [$request->searchBy,'LIKE',"%$request->inputSearch%"];
        }
        if (Auth::user()->idRol != 1) {
            $where[] = ['idDependencia',Auth::user()->idDependencia];
        }
        $listaArchivadores = Archivador::with('area','user')
        ->whereHas('area', function ($model) use ($request) {
            if($request->searchBy == 'nombreArea') {
                $model->where('nombre','LIKE',"%$request->inputSearch%");
            }
        })
        ->where($where)->paginate($request->paginate);
        return $listaArchivadores;
    }
    public function listUser(Request $request)
    {
        $listaArchivadores = Archivador::with('area','user')
                                        ->where(function ($query){
                                                $query->where(function($subQuery){
                                                    $subQuery->where('idDependencia', '=', Auth::user()->idDependencia)->where('isPersonal',0);
                                                })->orWhere(function ($subQuery2){
                                                    $subQuery2->where('idDependencia', '=', Auth::user()->idDependencia)->where('iduser','=',Auth::user()->id);
                                                });
                                        })->get();
        return $listaArchivadores;
    }
    

    public function insert(StoreArchivador $request)
    {
        if(!$request->ajax()) return redirect()->route('home');

        $archivador = new Archivador;
        $archivador->nombre = $request->nombre;
        $archivador->periodo = $request->periodo;
        $archivador->isPersonal = $request->isPersonal;
        if (Auth::user()->idRol == 1) {
            $archivador->idUser = $request->idUser;
            $archivador->idDependencia = $request->idDependencia;
        }
        else{
            $archivador->idUser = Auth::user()->id;
            $archivador->idDependencia = Auth::user()->idDependencia;
        }
        

        $archivador->save();

        return $archivador;
        // return response()->json('Created.');
    }

    public function update(UpdateArchivador $request)
    {
        if(!$request->ajax()) return redirect()->route('home');


        $archivador = Archivador::find($request->id);
        if(Auth::user()->idRol == 1){
            $archivador->nombre = $request->nombre;
            $archivador->periodo = $request->periodo;
            $archivador->isPersonal = $request->isPersonal;
            $archivador->idUser = $request->idUser;
            $archivador->idDependencia = $request->idDependencia;
        }
        else{
            if($archivador->idUser == Auth::user()->id){
                $archivador->nombre = $request->nombre;
                $archivador->periodo = $request->periodo;
                $archivador->isPersonal = $request->isPersonal;
                $archivador->idUser = Auth::user()->id;
                $archivador->idDependencia = Auth::user()->idDependencia;
            }
        }
            

        $archivador->save();

        return $archivador;
    }
}
