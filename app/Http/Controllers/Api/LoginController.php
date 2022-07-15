<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;





class LoginController extends Controller
{
    public function login (Request $request) {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($loginData)) {

            return response([
                'message' => 'Las credenciales son incorrectas.']);
        }

       $accessToken = auth()->user()->createToken('authToken')->accessToken;
      
        return response([
            'user' => auth()->user(),
            'access_Token' => $accessToken
        
        ]);

    }
}
