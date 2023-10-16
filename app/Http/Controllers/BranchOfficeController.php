<?php

namespace App\Http\Controllers;

use App\BranchOffice;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBranchOffice;
use App\Http\Requests\UpdateBranchOffice;


class BranchOfficeController extends Controller
{
    
    public function list(Request $request)
    {
        if(!$request->ajax()){return \Redirect::to(route('home'));}
        $branchOffices =  BranchOffice::all();
        return $branchOffices;        
    }

    public function insert(StoreBranchOffice $request)
    {
        if(!$request->ajax()){return \Redirect::to(route('home'));}
        $branchOffice = BranchOffice::create($request->all());
        return  $branchOffice;  
    }

    public function update(UpdateBranchOffice $request)
    {
        if(!$request->ajax()){return \Redirect::to(route('home'));}
        
        $branchOffice = BranchOffice::findOrFail($request->id);

        $branchOffice->codigo = $request->codigo;
        $branchOffice->nombre = $request->nombre;
        $branchOffice->idDepartamento = $request->idDepartamento;
        $branchOffice->idProvincia = $request->idProvincia;
        $branchOffice->idDistrito = $request->idDistrito;
        $branchOffice->direccion = $request->direccion;
        $branchOffice->email = $request->email;
        $branchOffice->celular = $request->celular;
        $branchOffice->detalle = $request->detalle;

        $branchOffice->save();

        return $branchOffice;

    }
}
