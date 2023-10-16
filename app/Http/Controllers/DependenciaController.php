<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;

use App\Http\Requests\DependenciaStore;
use App\Http\Requests\DependenciaUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DependenciaController extends Controller
{
    public function list(Request $request)
    {
        $where = [];
        if($request->searchBy && $request->inputSearch){
            $where[] = [$request->searchBy,'LIKE',"%$request->inputSearch%"];
        }
        $dependencia = Dependencia::where($where)->paginate($request->paginate);
        return $dependencia;
    }

    public function insert(DependenciaStore $request)
    {
        if(!$request->ajax()) return redirect()->route('home');
        $dependencia = new Dependencia();
        $dependencia->nombre = $request->nombre;
        $dependencia->abreviado = $request->abreviado;
        $dependencia->siglas = $request->siglas;
        $dependencia->representante = $request->representante;
        $dependencia->cargo = $request->cargo;
        $dependencia->observaciones = $request->observaciones;
        $dependencia->fechaRegistro = Carbon::now()->format('Y-m-d');
        $dependencia->maxEnProceso = 30;
        $dependencia->save();

        return $dependencia;
    }

    public function update(DependenciaUpdate $request)
    {
        if(!$request->ajax()) return redirect()->route('home');

        $dependencia = Dependencia::find($request->id);
        $dependencia->nombre = $request->nombre;
        $dependencia->abreviado = $request->abreviado;
        $dependencia->siglas = $request->siglas;
        $dependencia->representante = $request->representante;
        $dependencia->cargo = $request->cargo;
        $dependencia->observaciones = $request->observaciones;
        // $dependencia->fechaRegistro = $request->fechaRegistro;
        // $dependencia->maxEnProceso = $request->maxEnProceso;
        $dependencia->save();
        return $dependencia;
    }
}
