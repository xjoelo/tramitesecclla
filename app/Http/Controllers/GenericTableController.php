<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenericTableController extends Controller{


	public function listTableRegisterActives(Request $request)
	{
    $list = DB::table($request->model)->where('isActive',true)->get();
    return $list;
	}

	public function changeStatus(Request $request)
	{
    DB::table($request->model)->where('id',$request->id)->update(['isActive' => $request->isActive]);
	}

	public function delete(Request $request)
	{
    DB::table($request->model)->where('id',$request->id)->delete();
	}
}
