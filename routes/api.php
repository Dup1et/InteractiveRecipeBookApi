<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
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

Route::group(['prefix' => '/auth'], function () {
    Route::group(['prefix' => '/login'], function () {
        Route::get('/google', [AuthController::class, 'loginWithGoogle']);
        Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);
    });
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/refresh', [AuthController::class, 'refresh']);
});

Route::group(['prefix' => '/languages'], function () {
    Route::get('/', [LanguageController::class, 'index']);
    Route::get('/{language}', [LanguageController::class, 'show']);
});

Route::group(['prefix' => '/recipes'], function () {
    Route::get('/', [RecipeController::class, 'index']);
    Route::get('/{recipe}', [RecipeController::class, 'show']);
    Route::middleware('auth')->group(function () {
        Route::post('/', [RecipeController::class, 'store']);
        Route::match(['put', 'patch'], '/{recipe}', [RecipeController::class, 'update']);
        Route::delete('/{recipe}', [RecipeController::class, 'destroy']);
    });
});
