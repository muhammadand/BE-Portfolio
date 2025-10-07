<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\ProductCategoryController;
use App\Http\Controllers\Api\V1\ActivityLogController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\VendorController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\EnumerationController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Routes for version 1 of the API. All routes are prefixed with "api/v1".
|
*/

// -----------------------------
// Authentication Routes
// -----------------------------
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    // Protected auth routes
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::get('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// -----------------------------
// Protected Routes (require auth:api)
// -----------------------------
Route::middleware('auth:api')->group(function () {

    // User management
    Route::get('users/active', [UserController::class, 'active'])->name('users.active');
    Route::get('users/all', [UserController::class, 'all'])->name('users.all');
    Route::apiResource('users', UserController::class)->names('users');

    // Product Categories
    Route::apiResource('product-categories', ProductCategoryController::class)
        ->names('product-categories');

    // Roles
    Route::apiResource('roles', RoleController::class)->names('roles');

    // Permissions
    Route::apiResource('permissions', PermissionController::class)->names('permissions');
// Activity Logs
Route::get('activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity-logs.index');
      // Vendors ✅
      Route::apiResource('vendors', VendorController::class)->names('vendors');
      Route::apiResource('products', ProductController::class)->names('products');
    
  // ✅ Import Products via Google Spreadsheet
  Route::post('products/import/spreadsheet', [ProductController::class, 'importFromSpreadsheet'])
  ->name('products.import.spreadsheet');
  Route::apiResource('enumerations', EnumerationController::class)
  ->names('enumerations');

    
});
