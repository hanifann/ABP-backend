<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RecomendationController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\WishlistController;

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

/* tambah throttle untuk membatasi maksimal percobaan login, 
maksimal percobaan 5x dan cooldown selama 1 menit */
Route::post('login', [AuthController::class, 'authenticate'])->middleware("throttle:5,1");
Route::post('register', [AuthController::class, 'register'])->name('reg');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', [AuthController::class, 'me']);
    Route::get('banner', [BannerController::class, 'index']);
    Route::post('banner', [BannerController::class, 'create']);
    Route::put('banner/{id}', [BannerController::class, 'update']);
    Route::delete('banner/{id}', [BannerController::class, 'delete']);
    Route::get('recomendation', [RecomendationController::class, 'index']);
    Route::post('recomendation', [RecomendationController::class, 'create']);
    Route::put('recomendation/{id}', [RecomendationController::class, 'update']);
    Route::delete('recomendation/{id}', [RecomendationController::class, 'delete']);
    Route::get('travel', [TravelController::class, 'index']);
    Route::post('travel', [TravelController::class, 'create']);
    Route::put('travel/{id}', [TravelController::class, 'update']);
    Route::delete('travel/{id}', [TravelController::class, 'delete']);
    Route::get('wishlist/{user_id}', [WishlistController::class, 'index']);
    Route::post('wishlist', [WishlistController::class, 'create']);
    Route::delete('wishlist/{id}', [WishlistController::class, 'delete']);
});