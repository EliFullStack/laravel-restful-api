<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role != "1") {
            return response()->json([
                'message' => 'No estás autorizado para realizar esta petición.',
                'status' => 403,
            ]);
        } else {
            
            $users = DB::table('users')
            ->select('*')
            ->get();
        
            return response()->json([
            'users' => $users,
            'status' => 200

        ]);

        }  
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateName(Request $request, $id)
    {
        $authorized = Auth::user()->id;

        if (!User::find($id)) {
            return response([
                "message" => "Este usuario no existe."
                    ], 422);
        } elseif ($authorized == $id) {
            $user = User::find($id);
            $request->validate([
                'nickname' => 'required|max:15|unique:users,nickname,'.$user->id,
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,   
            ]);
        } else {
            return response([
                "message" => "No estás autorizado para realizar esta acción."
                    ], 401);
        }

        $user->update($request->all());
        return response($user, 200);

    }       
        
    }
