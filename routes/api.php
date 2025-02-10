<?php

use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\LeagueController;
use App\Http\Controllers\Admin\CupController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\AuthController as UserAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/')->group(function () {
    Route::post('login', [UserAuthController::class, 'login']);
    Route::middleware('sanctum.user')->group(function () {
        Route::get('user', [UserAuthController::class, 'user']);
    });
});


Route::prefix('admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware('sanctum.admin')->group(function () {
        Route::post('refresh_token', [AdminAuthController::class, 'refreshToken']);
        Route::post('logout', [AdminAuthController::class, 'logout']);

        Route::get('schedule', [CommonController::class, 'schedule']);
        Route::post('upload', [CommonController::class, 'upload']);

        Route::resource('user', UserController::class);
        Route::get('all_users', [UserController::class, 'getAll']);

        Route::resource('player', PlayerController::class);

        Route::resource('league', LeagueController::class);
        Route::get('league_users/{id}', [LeagueController::class, 'leagueUsers']);
        Route::post('update_league_data/{id}', [LeagueController::class, 'updateLeagueData']);
        Route::get('league_games', [LeagueController::class, 'leagueGames']);
        Route::post('update_league_game/{id}', [LeagueController::class, 'updateLeagueGames']);
        Route::get('league_ranking', [LeagueController::class, 'leagueRanking']);

        Route::resource('cup', CupController::class);
        Route::get('cup_users/{id}', [CupController::class, 'cupUsers']);
        Route::post('update_cup_data/{id}', [CupController::class, 'updateCupData']);
        Route::get('cup_games', [CupController::class, 'cupGames']);
        Route::post('update_cup_game/{id}', [CupController::class, 'updateCupGames']);
        Route::get('cup_ranking', [CupController::class, 'cupRanking']);

        Route::resource('news', NewsController::class);
    });
});
