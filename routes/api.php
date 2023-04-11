<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SoonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('welcome', [WelcomeController::class, 'welcome']);
Route::get('soon', [SoonController::class, 'soon']);
Route::get('banner', [BannerController::class, 'banner']);
Route::get('games', [GameController::class, 'games']);
Route::post('game_id', [GameController::class, 'game_id']);

Route::get('send', [UserController::class, 'send']);
Route::post('login', [UserController::class, 'login']);
Route::post('verify', [UserController::class, 'verify']);
