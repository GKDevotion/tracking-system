<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\TrackingController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

// ─── Guest Routes ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('otp.send');

    Route::get('/verify-otp', [AuthController::class, 'otpForm'])->name('otp.verify.form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');

    Route::get('/reset-password', [AuthController::class, 'resetForm'])->name('reset.password.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
});

// ─── Authenticated Routes ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('web.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Change Password
    Route::get('/change-password', [AuthController::class, 'changePasswordForm'])->name('web.change.password.form');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('web.change.password');

    // Roles
    // Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('roles', RoleController::class)
            ->except(['show'])
            ->names([
                'index' => 'web.roles.index',
                'create' => 'web.roles.create',
                'store' => 'web.roles.store',
                'edit' => 'web.roles.edit',
                'update' => 'web.roles.update',
            ]);

    // Menus
    // Route::resource('menus', MenuController::class)->except(['show']);
    Route::resource('menus', MenuController::class)
            ->except(['show'])
            ->names([
                'index' => 'web.menus.index',
                'create' => 'web.menus.create',
                'store' => 'web.menus.store',
                'edit' => 'web.menus.edit',
                'update' => 'web.menus.update',
            ]);

    // Permissions
    // Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{role}', [PermissionController::class, 'show'])->name('web.permissions.show');
    Route::post('/permissions/{role}', [PermissionController::class, 'update'])->name('web.permissions.update');

    Route::resource('permissions', PermissionController::class)
            // ->except(['show'])
            ->names([
                'index' => 'web.permissions.index',
                'create' => 'web.permissions.create',
                'edit' => 'web.permissions.edit',
                // 'update' => 'web.permissions.update',
            ]);

    // Users
    Route::resource('users', UserController::class)
            ->names([
                'index' => 'web.users.index',
                'create' => 'web.users.create',
                'edit' => 'web.users.edit',
                'update' => 'web.users.update',
                'show' => 'web.users.show',
            ]);

    // Tracking
    Route::resource('tracking', TrackingController::class)
            ->except(['destroy', 'edit', 'update'])
            ->names([
                'index' => 'web.tracking.index',
                'create' => 'web.tracking.create',
                'store' => 'web.tracking.store',
                'show' => 'web.tracking.show',
            ]);
    Route::get('/tracking/{tracking}/edit', [TrackingController::class, 'edit'])->name('web.tracking.edit');
    Route::put('/tracking/{tracking}', [TrackingController::class, 'update'])->name('web.tracking.update');

    // Business mail Category
    Route::resource('bm-category', UserController::class)
            ->names([
                'index' => 'web.bm-category.index',
                'create' => 'web.bm-category.create',
                'edit' => 'web.bm-category.edit',
                'update' => 'web.bm-category.update',
                'show' => 'web.bm-category.show',
            ]);

    // Business mail Template
    Route::resource('bm-mail-template', UserController::class)
            ->names([
                'index' => 'web.bm-mail-template.index',
                'create' => 'web.bm-mail-template.create',
                'edit' => 'web.bm-mail-template.edit',
                'update' => 'web.bm-mail-template.update',
                'show' => 'web.bm-mail-template.show',
            ]);

    // Business mail Client
    Route::resource('bm-client', UserController::class)
            ->names([
                'index' => 'web.bm-client.index',
                'create' => 'web.bm-client.create',
                'edit' => 'web.bm-client.edit',
                'update' => 'web.bm-client.update',
                'show' => 'web.bm-client.show',
            ]);

    // Business mail Logs
    Route::resource('bm-mail-logs', UserController::class)
            ->names([
                'index' => 'web.bm-mail-logs.index',
                'create' => 'web.bm-mail-logs.create',
                'edit' => 'web.bm-mail-logs.edit',
                'update' => 'web.bm-mail-logs.update',
                'show' => 'web.bm-mail-logs.show',
            ]);

    // Sales Person
    Route::resource('sales', UserController::class)
            ->names([
                'index' => 'web.sales.index',
                'create' => 'web.sales.create',
                'edit' => 'web.sales.edit',
                'update' => 'web.sales.update',
                'show' => 'web.sales.show',
            ]);
});
