<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
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
        Route::get('user', [UserController::class, 'user']),
        Route::put('users/info', [UserController::class, 'updateInfo']),
        Route::put('users/password', [UserController::class, 'updatePassword']),

        Route::apiResource('users',UserController::class),
        Route::apiResource('roles', RoleController::class)
    ])
]);
