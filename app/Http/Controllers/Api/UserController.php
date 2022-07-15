<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            return $user->nickname;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateName(Request $request, User $player)
    {
        
        $request->validate([
            'nickname' => 'required|max:15|unique:users,nickname,'.$player->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$player->id,
            
        ]);

        $player->update($request->all());
        return response($player, 200);
        
    }


}
