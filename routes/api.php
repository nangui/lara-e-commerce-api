<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariationController;
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
        Route::post('logout', [AuthController::class, 'logout']),
        Route::get('user', [UserController::class, 'user']),
        Route::put('users/info', [UserController::class, 'updateInfo']),
        Route::put('users/password', [UserController::class, 'updatePassword']),

        Route::apiResource('users',UserController::class),
        Route::apiResource('roles', RoleController::class),
        Route::get('permissions', [PermissionController::class, 'index']),
        Route::apiResource('categories', CategoryController::class),
        Route::apiResource('products', ProductController::class),
        Route::apiResource('variations', VariationController::class),
        Route::apiResource('orders', OrderController::class),
        Route::get('export-csv', [OrderController::class, 'exportAsCsvFile']),
        Route::get('chart', [DashboardController::class, 'chart'])
    ])
]);
