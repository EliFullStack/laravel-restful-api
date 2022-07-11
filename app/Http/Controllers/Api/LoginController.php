<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;




class LoginController extends Controller
{
    public function login (Request $request) {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response([
                'message' => 'El usuario y/o la contraseña son inválidos.']);
        }

       // $newUser = Auth::create();
      //  $accessToken = $newUser->createToken('authToken')->accessToken;
        
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
      
        return response([
            'user' => auth()->user(),
            'access_Token' => $accessToken
        
        ]);

    }
}
