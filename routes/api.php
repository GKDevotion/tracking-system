<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TrackingController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

// ─── Public Auth Routes ────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// ─── Protected Routes ─────────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Roles
    Route::apiResource('roles', RoleController::class);

    // Menus
    Route::apiResource('menus', MenuController::class);

    // Permissions
    Route::get('/permissions/{role}', [PermissionController::class, 'show']);
    Route::post('/permissions/{role}', [PermissionController::class, 'update']);

    // Users
    Route::apiResource('users', UserController::class);

    // Tracking
    Route::apiResource('tracking', TrackingController::class)->except(['destroy']);
});
