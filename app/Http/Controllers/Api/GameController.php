<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalGames = DB::table('games')
        ->select('games.user_id', DB::raw('count(*) as totalGames'))
        ->groupBy('games.user_id')
        ->get();

      //  return $totalGames;

        $totalGamesGanados = DB::table('games')
        ->select(DB::sum('(games.dice1 + games.dice2) as totalDados'),'games.user_id', 
                 DB::raw('count(*) as totalGames'))
        ->groupBy('games.user_id')
        ->where('totalDados == 7')
        ->get();

        return $totalGamesGanados;


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

        Game::create([
            "dice1" => $dice1,
            "dice2" => $dice2,
            "user_id" => $id
        ])
        ->where('user_id', '=', $id)
        ->get();

        if ($sum == 7) {
            return "La suma de los dados es: " . $sum . ", ha ganado la partida.";
        }

            return "La suma de los dados es: " . $sum . ", ha perdido la partida.";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function showPlayerGames($id)
    {
        $playerGames = Game::where('user_id', '=', $id)
        ->get();

        return $playerGames;
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
        Game::where('user_id', '=', $id)
        ->delete();

        return 'Las tiradas del jugador cuyo id = '. $id . ', han sido eliminadas.';
        
    }
}
