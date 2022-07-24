<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Middleware;
use GuzzleHttp\Middleware as GuzzleHttpMiddleware;

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

Route::get('users', [UserController::class, 'index'])->middleware('can:api.users.index')->name('api.users.index');
    
Route::post('logout', [LogoutController::class, 'logout'])->name('api.logout');

Route::get('players', [GameController::class, 'averageSuccessRate'])/*->middleware('can:api.players.averageSuccessRate')*/->name('api.players.averageSuccessRate');

Route::get('players/{player}/games', [GameController::class, 'showPlayerGames'])/*->middleware('can:api.players.showPlayerGames')*/->name('api.players.showPlayerGames');

Route::put('players/{player}', [UserController::class, 'updateName'])->middleware('can:api.players.updateName')->name('api.players.updateName');

Route::delete('players/{id}/games', [GameController::class, 'destroyPlayerThrows'])/*->middleware('can:api.players.destroyPlayerThrows')*/->name('api.players.destroyPlayerThrows');

Route::post('players/{id}/games', [GameController::class, 'throwDice'])/*->middleware('can:api.players.throwDice')*/->name('api.players.throwDice');

Route::get('players/ranking', [GameController::class, 'getRanking'])->middleware('can:api.players.getRanking')->name('api.players.getRanking');

Route::get('players/ranking/loser', [GameController::class, 'getWinner'])->middleware('can:api.players.getWinner')->name('api.players.getWinner');

Route::get('players/ranking/winner', [GameController::class, 'getLoser'])->middleware('can:api.players.getLoser')->name('api.players.getLoser');

});

