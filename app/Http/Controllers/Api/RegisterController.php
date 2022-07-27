<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store (Request $request) {
        
        if ($request['nickname'] == null) {
            $validatedData = $request->validate([
                'nickname' => 'nullable',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required'
            ]);
            $validatedData['nickname'] = 'Anónimo';
        } else {
            $validatedData = $request->validate([
                'nickname' => 'required|string|unique:users|max:15',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required'
            ]);
        }

        $validatedData['password'] = Hash::make($request->password);
        
        $user = User::create($validatedData);
       
        
        $accesToken = $user->createToken('authToken')->accessToken;
        
        return response ([
            'message' => 'El usuario '.$user['nickname'].' ha sido creado con éxito.',   
            'access_token' => $accesToken
        ], 201);
        
    }
}
