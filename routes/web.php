<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\IndexController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index']);
Route::get('/get_news', [IndexController::class, 'getNews']);

Route::get('/league_ranking_view/{leagueId}', [IndexController::class, 'leagueRankingView']);
Route::get('/league_ranking/{leagueId}', [IndexController::class, 'leagueRanking']);

Route::get('/league_games_view/{leagueId}', [IndexController::class, 'leagueGamesView']);
Route::get('/league_games/{leagueId}', [IndexController::class, 'leagueGames']);

Route::get('/user_games_view/{userId}', [IndexController::class, 'userGamesView']);
Route::get('/user_games/{userId}', [IndexController::class, 'userGames']);

Route::get('/admins', [WebController::class, 'admin']);
Route::get('/test', [WebController::class, 'test']);
