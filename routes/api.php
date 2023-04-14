<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GamesCountryController;
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
Route::post('bannerC', [BannerController::class, 'bannerC']);
Route::get('games', [GameController::class, 'games']);
Route::post('game_id', [GameController::class, 'game_id']);
Route::post('search', [GameController::class, 'search']);

Route::get('send', [UserController::class, 'send']);
Route::post('login', [UserController::class, 'login']);
Route::post('verify', [UserController::class, 'verify']);
Route::get('favouriteGames', [UserController::class, 'favouriteGames']);
Route::get('cartGames', [UserController::class, 'cartGames']);
Route::post('pfp', [UserController::class, 'pfp']);




Route::post('gamesCountries', [GamesCountryController::class, 'gamesCountries']);


Route::post('add_fav', [UserController::class, 'add_fav']);
Route::post('addToCart', [UserController::class, 'addToCart']);



Route::post('packages', [GameController::class, 'packages']);


Route::get('currency', [CurrencyController::class, 'currency']);


