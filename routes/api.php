<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(fn () => [
    Route::post('login', [AuthController::class, 'login']),
    Route::post('register', [AuthController::class, 'register']),
    Route::group(['middleware' => 'auth:api'], fn () => [
        Route::apiResource('users',UserController::class)
    ])
]);
