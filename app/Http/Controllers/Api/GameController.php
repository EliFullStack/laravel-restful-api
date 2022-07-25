<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function averageSuccessRate() {

        if (Auth::user()->role != "1") {
            return response()->json([
                'message' => 'No estás autorizado para realizar esta petición.',
                'status' => 403,
            ]);
        } else {
            $successRate = DB::table('games')
       ->join('users', 'games.user_id', '=', 'users.id')
       ->selectRaw('users.nickname, count(games.winner_loser) as totalGames, sum(games.winner_loser = 1) as partidasGanadas ,round(100*sum(games.winner_loser = 1)/count(games.winner_loser)) as successRate')         
       ->groupBy('users.nickname')
       ->get();

       return response()->json([
        "successRate" => $successRate,
       ]); 

        }

       
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

        $authorized = Auth::user()->id;

        if (!User::find($id)) {
            return response([
                "message" => "Este usuario no existe."
                    ], 422);
        } elseif ($authorized == $id) {
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
        } else {
            return response([
                "message" => "No estás autorizado para realizar esta acción.",
                "status" => 403
                ]);
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
        $authorized = Auth::user()->id;
        $game = Game::where('user_id', $id)->first('id');

        if (!User::find($id)) {
            return response([
                "message" => "Este usuario no existe.",
                "status" => 422
                ]);
        } elseif ($authorized == $id) {
            
            $playerGames = DB::table('games')
            ->where('user_id', '=', $id)
            ->get();
            return $playerGames;
        
        } elseif ($game == null) {
            return response() ->json([
                "message" => "Este jugador no tiene jugadas para mostrar.",
            ]);
        } else {
            return response([
                "message" => "No estás autorizado para realizar esta acción.",
                "status" => 403
                ]);
        }
    }      
        
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroyPlayerThrows($id)
    {
        $authorized = Auth::user()->id;
        $game = Game::where('user_id', $id)->first('id');
      


        if (!User::find($id)) {
            return response() ->json([
                "message" => "Este usuario no existe.",
                "status" => 422
                ]);
        } elseif ($authorized == $id) {
            if ($game == null) {
                return response() ->json([
                    "message" => "Este jugador no tiene tiradas para eliminar.",
                 ]);
            } else {
                DB::table('games')
            ->where('user_id', '=', $id)
            ->delete();

            return response()->json([
                "message" =>  'Las tiradas de este jugador han sido eliminadas.',
            ]);
            }
        } else {
            return response([
                "message" => "No estás autorizado para realizar esta acción.",
                "status" => 403
                ]);
        } 
       
    }

    public function getRanking() {

        if (Auth::user()->role != "1") {
            return response()->json([
                'message' => 'No estás autorizado para realizar esta petición.',
                'status' => 403,
            ]);
        } else {

        $ranking = DB::table('games')
        
        ->join('users', 'games.user_id', '=', 'users.id')
        ->selectRaw('users.nickname, count(games.winner_loser) as totalGames, sum(games.winner_loser = 1) as partidasGanadas ,round(100*sum(games.winner_loser = 1)/count(games.winner_loser)) as successRate')  
        ->orderby('successRate', 'desc')
        ->orderby('totalGames', 'asc')
        ->groupby('users.nickname')
        ->get();

            return response()->json([
                
                "ranking" => $ranking,
            ]);
        }
    }

    public function getWinner() {

        if (Auth::user()->role != "1") {
            return response()->json([
                'message' => 'No estás autorizado para realizar esta petición.',
                'status' => 403,
            ]);
        } else {

        $winner = DB::table('games')
        
        ->join('users', 'games.user_id', '=', 'users.id')
        ->selectRaw('users.nickname, count(games.winner_loser) as totalGames, sum(games.winner_loser = 1) as partidasGanadas ,round(100*sum(games.winner_loser = 1)/count(games.winner_loser)) as successRate')  
        ->orderby('successRate', 'desc')
        ->orderby('totalGames', 'asc')
        ->groupby('users.nickname')
        ->limit(1)
        ->get();

            return response()->json([
                
                "winner" => $winner,
            ]);
        }
    }

    public function getLoser() {

        if (Auth::user()->role != "1") {
            return response()->json([
                'message' => 'No estás autorizado para realizar esta petición.',
                'status' => 403,
            ]);
        } else {

        $loser = DB::table('games')
        
        ->join('users', 'games.user_id', '=', 'users.id')
        ->selectRaw('users.nickname, count(games.winner_loser) as totalGames, sum(games.winner_loser = 1) as partidasGanadas ,round(100*sum(games.winner_loser = 1)/count(games.winner_loser)) as successRate')  
        ->orderby('successRate', 'asc')
        ->orderby('totalGames', 'desc')
        ->groupby('users.nickname')
        ->limit(1)
        ->get();

            return response()->json([
                
                "loser" => $loser,
            ]);
        }
    }
}
