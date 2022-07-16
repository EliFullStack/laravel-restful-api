<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Middleware;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:api')->get('user', function (Request $request) {
        return $request->user();
    });



Route::post('login', [LoginController::class, 'login'])->name('api.login');

Route::post('register', [RegisterController::class, 'store'])->name('api.register');



Route::middleware('auth:api')->group(function () {
    
Route::post('logout', [LogoutController::class, 'logout'])->name('api.logout');

Route::get('players', [GameController::class, 'averageSuccessRate'])->name('api.players.averageSuccessRate');

Route::get('players/{player}/games', [GameController::class, 'showPlayerGames'])->name('api.players.showPlayerGames');

Route::put('players/{player}', [UserController::class, 'updateName'])->name('api.players.updateName');

Route::delete('players/{id}/games', [GameController::class, 'destroyPlayerThrows'])->name('api.players.destroyPlayerThrows');

Route::post('players/{id}/games', [GameController::class, 'throwDice'])->name('api.players.throwDice');

Route::get('players/ranking', [GameController::class, 'getRanking'])->name('api.players.getRanking');

Route::get('players/ranking/loser', [GameController::class, 'getWinner'])->name('api.players.getWinner');

Route::get('players/ranking/winner', [GameController::class, 'getLoser'])->name('api.players.getLoser');

});

