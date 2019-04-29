<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function login(Request $request){
		$credentials = $request->only('username', 'password');

	    Auth::attempt($credentials);
	    return response()->json(['message' => 'ok', 'id' => Auth::id()]);
		
	}

	public function logout(){
		Auth::logout();
	}

    public function id(){
        return response()->json(['id' => Auth::id()]);    
    }
}
