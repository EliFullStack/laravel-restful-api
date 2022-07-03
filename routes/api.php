<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'store'])->name('api.register');


Route::get('players', [UserController::class, 'index'])->name('api.players.index');

Route::post('players', [UserController::class, 'store'])->name('api.players.store');

Route::get('players/{player}/games', [UserController::class, 'show'])->name('api.players.show');

Route::put('players/{player}', [UserController::class, 'update'])->name('api.players.update');

Route::delete('players/{player}', [UserController::class, 'destroy'])->name('api.players.destroy');

Route::post('players/{player}/games', [UserController::class, 'throwDice'])->name('api.players.throwDice');

Route::get('players/{player}/games', [UserController::class, 'getPlayerThrows'])->name('api.players.getPlayerThrows');

Route::get('players/ranking', [UserController::class, 'getRanking'])->name('api.players.getRanking');

Route::get('/players/ranking/loser', [UserController::class, 'getWinner'])->name('api.players.getWinner');

Route::get('/players/ranking/winner', [UserController::class, 'getLoser'])->name('api.players.getLoser');