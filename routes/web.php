<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\PurchaseController;
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
    Route::get('/web/dashboard', [DashboardController::class, 'index'])->name('web.dashboard');
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

            // Blogs
    Route::resource('blogs', UserController::class)
            ->names([
                'index' => 'web.blogs.index',
                'create' => 'web.blogs.create',
                'edit' => 'web.blogs.edit',
                'update' => 'web.blogs.update',
                'show' => 'web.blogs.show',
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
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');