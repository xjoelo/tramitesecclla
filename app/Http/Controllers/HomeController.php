<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operacion;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $documentosPorRecibir = Operacion::where(function ($query){
                                    $query->where(function($subQuery){
                                        $subQuery->where('idDependenciaDestino', '=', Auth::user()->idDependencia)->whereNull('iduserDestino');
                                    })->orWhere(function ($subQuery2){
                                        $subQuery2->where('idDependenciaDestino', '=', Auth::user()->idDependencia)->where('iduserDestino','=',Auth::user()->id);
                                    });
                                })
                                ->where('tipoOperacion', 2)
                                ->where('isProcesado', 0)
                                ->count();
        $documentosDerivados = Operacion::where('idDependencia', Auth::user()->idDependencia)
                                ->where('tipoOperacion', 2)
                                ->where('isProcesado', 0)
                                ->count();

        $documentosEnProceso = Operacion::where('idDependencia', Auth::user()->idDependencia)
                                ->where('tipoOperacion', 1)
                                ->where('isProcesado', 0)
                                ->count();


        return view('home',compact('documentosDerivados','documentosEnProceso','documentosPorRecibir'));
    }
}
