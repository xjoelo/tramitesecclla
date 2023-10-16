<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
	public function list(Request $request)
    {
        if(!$request->ajax()) return redirect()->route('home');

        $where = [];
        if($request->searchBy && $request->inputSearch){
            $where []= [$request->searchBy,'LIKE',"%".$request->inputSearch.'%'];
        }

        $listUsers = User::with(['dependencia','role'])->where($where)->paginate($request->paginate);
        return $listUsers;
    }

    public function insert(UserStore $request)
    {
        if(!$request->ajax()) return redirect()->route('home');
        $user = User::create($request->all());
        return $user;
    }

    public function update(UserUpdate $request)
    {
        if(!$request->ajax()) return redirect()->route('home');
        User::where('id',$request->id)->update($request->except(['id','password']));
        if($request->password != 'n0tm0d1f1ed'){
            $user = User::findOrFail($request->id);
            $user->password = $request->password;
            $user->save();
        }
        return 1;
    }
    public function listForArea(Request $request)
    {
        $usuarios = User::where('idDependencia',Auth::user()->idDependencia)->get();
        return $usuarios;
    }

    public function listForAreaValue(Request $request)
    {  
        if(!$request->ajax()) return redirect()->route('home');
        $usuarios = User::where('idDependencia',$request->idArea)->get();
        return $usuarios;

                
    }
    public function changePassword(Request $request)
    {
        $usuario = User::findOrFail(Auth::user()->id);

        // $error = ['messages' => $usuario->password ];
        // return redirect()->back()->withErrors($error);

        if (Hash::check($request->passwordAnterior,$usuario->password)){
            if ($request->newPassword == $request->repitPassword){
                $usuario->password = $request->newPassword;
                $usuario->save();
                return redirect()->back()->withErrors(['success'=> 1]);
            }
            else{
                $error = ['message' => "LAS NUEVAS CONTRASEÑAS NO COINCIDEN"];
                return redirect()->back()->withErrors($error);
            }
        }
        else{
            $error = ['message' => "LA CONTRASEÑA ACTUAL NO ES LA CORRECTA"];
            return redirect()->back()->withErrors($error);
        }

    }

}
