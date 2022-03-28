<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register'])->name('reg');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', [AuthController::class, 'me']);
    // Route::get('banner', [ProductController::class, 'index']);
    // Route::post('banner', [ProductController::class, 'index']);
    // Route::put('banner/{item}', [ProductController::class, 'index']);
    // Route::delete('banner/{item}', [ProductController::class, 'index']);
});