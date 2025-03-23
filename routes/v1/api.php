<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for version 1 of your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group with the prefix "api/v1".
|
*/

// Authentication Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    
    // Protected routes
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('me', [AuthController::class, 'me'])->name('auth.me');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
});

// Users - Protected routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('users', UserController::class);
    Route::get('users/active', [UserController::class, 'active'])->name('users.active');
});
