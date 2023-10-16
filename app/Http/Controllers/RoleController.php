<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	public function list(Request $request)
	{
	    if(!$request->ajax()){return \Redirect::to(route('home'));}
	    $roles = Role::all();
	    return $roles;
	}
}
