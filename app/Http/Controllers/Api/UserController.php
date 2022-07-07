<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $users = DB::table('users')
        ->join('games' , 'user_id', '=', 'users.id')
        ->select(DB::raw("
                    users.id,
                    users.nickname,
                    games.dice1,
                    games.dice2,
                    (games.dice1 + games.dice2) as sum 
                  "))
        //->select(DB::raw('count(games.id) as user_count'))
        ->get();

        
        foreach ($users as $id => $user) {
            $totalGames = Game::count('id')
            ->where('user_id', '=', $id)
            ->get();
            return $totalGames;
        }

      //  return $users;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|unique:users|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($request->all());
        return response($user, 200);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */


    public function getRanking() {

    }

    public function getWinner() {

    }

    public function getLoser() {

    }

}
