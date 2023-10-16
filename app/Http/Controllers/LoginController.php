<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	public function login(Request $request)
	{
		// $credentials = request()->only('email','password');
		Auth::attempt(['email' => $request->email, 'password' => $request->password]);
	}
}
