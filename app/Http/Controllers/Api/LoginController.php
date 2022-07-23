<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;





class LoginController extends Controller
{
    public function login (Request $request) {
        $loginData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($loginData)) {

            return response()->json([
                "message" => "Invalid email or password.",
                "status" => 401
            ]);
        }

        $user = $request->user();

        $accessToken = $user->createToken('authToken')->accessToken;
      
        return response()->json([
            "user" => $user,
            "access_Token "=> $accessToken,
            "status" => 200
        
        ]);

    }
}
