<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class GameController extends Controller
{

    public function averageSuccessRate() {

       $successRate = DB::table('games')
       ->join('users', 'games.user_id', '=', 'users.id')
       ->selectRaw('users.nickname, count(games.winner_loser) as totalGames, sum(games.winner_loser = 1) as partidasGanadas ,round(100*sum(games.winner_loser = 1)/count(games.winner_loser)) as successRate')         
       ->groupBy('users.nickname')
       ->get();

       return $successRate;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function throwDice($id) {
        
        $dice1 = rand(1,6);
        $dice2 = rand(1,6);
        $sum = $dice1 + $dice2;
        
        if ($sum == 7) {
            $result = 1;
        } else {
            $result = 0;
        }

        Game::create([
            "dice1" => $dice1,
            "dice2" => $dice2,
            "winner_loser" => $result,
            "user_id" => $id
        ])
        ->where('user_id', '=', $id)
        ->get();

        if ($result == 1) {
            return response([
               
                "message" => "La suma de los dados es: " . $sum . ", ha ganado la partida."]);
        } else {

            return response([
                
                "message" => "La suma de los dados es: " . $sum . ", ha perdido la partida."]);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function showPlayerGames($id)
    {
        $game = Game::where('user_id', $id)->first('id');

        $playerGames = DB::table('games')
        ->where('user_id', '=', $id)
        ->get();

        if (!User::find($id)) {
            return response() ->json([
                "message" => "Este jugador no existe.",
            ]);
        } elseif ($game == null) {
            return response() ->json([
                "message" => "Este jugador no tiene jugadas para mostrar.",
            ]);
        } else {
            return $playerGames;
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroyPlayerThrows($id)
    {
        
        DB::table('games')
        ->where('user_id', '=', $id)
        ->delete();

        return 'Las tiradas del jugador cuyo id = '. $id . ', han sido eliminadas.';
       
    }

    public function getRanking() {

    }

    public function getWinner() {

    }

    public function getLoser() {

    }
}
