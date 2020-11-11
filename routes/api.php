<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RecipeController;
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

Route::group(['prefix' => '/languages'], function () {
    Route::get('/', [LanguageController::class, 'index']);
    Route::get('/{id}', [LanguageController::class, 'show']);
});

Route::group(['prefix' => '/recipes'], function () {
    Route::get('/', [RecipeController::class, 'index']);
    Route::get('/{recipe}', [RecipeController::class, 'show']);
    Route::post('/', [RecipeController::class, 'create']);
    Route::put('/{recipe}', [RecipeController::class, 'update']);
    Route::delete('/{recipe}', [RecipeController::class, 'destroy']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
