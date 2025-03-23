<?php

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

// Users
Route::apiResource('users', UserController::class);
Route::get('users/active', [UserController::class, 'active'])->name('users.active');
