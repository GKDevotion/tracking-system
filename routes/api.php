<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BusinessMail\CategoryController;
use App\Http\Controllers\API\BusinessMail\ClientController;
use App\Http\Controllers\API\BusinessMail\MailLogController;
use App\Http\Controllers\API\BusinessMail\MailTemplateController;
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
    Route::get('parent-menu', [MenuController::class, 'parentMenu']);

    // Permissions
    Route::get('/permissions/{role}', [PermissionController::class, 'show']);
    Route::post('/permissions/{role}', [PermissionController::class, 'update']);

    // Users
    Route::apiResource('users', UserController::class);

    // Tracking
    Route::apiResource('tracking', TrackingController::class)->except(['destroy']);

    //Business Mailing
    Route::prefix('business-mail')->middleware(['auth:sanctum'])->group(function () {

        // ── Categories ────────────────────────────────────────────────────
        Route::apiResource('categories', CategoryController::class);

        // ── Mail Templates ────────────────────────────────────────────────
        Route::apiResource('templates', MailTemplateController::class);

        // Send this template to a client (alternative: from template side)
        Route::post('templates/{mailTemplate}/send-to-client', [MailTemplateController::class, 'sendToClient'])
            ->name('templates.sendToClient');

        // ── Clients ───────────────────────────────────────────────────────
        Route::apiResource('clients', ClientController::class);

        // Send mail to single client
        Route::post('clients/{client}/send-mail', [ClientController::class, 'sendMail'])
            ->name('clients.sendMail');

        // Mail history for a specific client
        Route::get('clients/{client}/mail-logs', [ClientController::class, 'mailLogs'])
            ->name('clients.mailLogs');

        // Bulk mail campaign
        Route::post('clients/bulk-send', [ClientController::class, 'bulkSend'])
            ->name('clients.bulkSend');

        // ── Mail Logs ─────────────────────────────────────────────────────
        Route::get('logs', [MailLogController::class, 'index'])->name('logs.index');
        Route::get('logs/stats', [MailLogController::class, 'stats'])->name('logs.stats');
    });

});
