<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Web\BmCategoryController;
use App\Http\Controllers\Web\BmClientController;
use App\Http\Controllers\Web\BmMailLogController;
use App\Http\Controllers\Web\BmMailTemplateController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DisclaimerController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RiskDisclosureController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\TagController;
use App\Http\Controllers\Web\TrackingController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\ConfigurationController;
use App\Http\Controllers\Web\PlanController;
use App\Http\Controllers\Web\PricingPlanCheckoutController;
use Illuminate\Support\Facades\Mail;
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

    // Configurations
    Route::resource('configurations', ConfigurationController::class)
            ->names([
                'index' => 'web.configurations.index',
                'create' => 'web.configurations.create',
                'store' => 'web.configurations.store',
                'show' => 'web.configurations.show',
                'edit' => 'web.configurations.edit',
                'update' => 'web.configurations.update',
                'destroy' => 'web.configurations.destroy',
            ]);

    // Pricing Plan Checkout
    Route::resource('pricing-plan-checkout', PricingPlanCheckoutController::class)
            ->names([
                'index' => 'web.pricing-plan-checkout.index',
                'edit' => 'web.pricing-plan-checkout.edit',
                'update' => 'web.pricing-plan-checkout.update',
                'show' => 'web.pricing-plan-checkout.show',
            ]);

    // Plans
    Route::resource('plans', PlanController::class)
            ->names([
                'index' => 'web.plans.index',
                'create' => 'web.plans.create',
                'store' => 'web.plans.store',
                'edit' => 'web.plans.edit',
                'update' => 'web.plans.update',
                'destroy' => 'web.plans.destroy',
            ]);

            // Blogs
    Route::resource('blog', BlogController::class)
            // ->except(['destroy', 'edit', 'update'])
            ->names([
                'index' => 'web.blog.index',
                'create' => 'web.blog.create',
                'store' => 'web.blog.store',
                'edit' => 'web.blog.edit',
                'update' => 'web.blog.update',
                'destroy' => 'web.blog.destroy',
            ]);

    // Route::get('/blog/{blog}/edit', [BlogController::class, 'edit'])->name('web.blogs.edit');
    // Route::put('/blog/{blog}', [BlogController::class, 'update'])->name('web.blogs.update');
    // Route::delete('/blog/{blog}', [BlogController::class, 'destroy'])->name('web.blogs.destroy');

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

    Route::resource('category', CategoryController::class)
            ->except(['destroy', 'edit', 'update'])
            ->names([
                'index' => 'web.category.index',
                'create' => 'web.category.create',
                'store' => 'web.category.store',
                'show' => 'web.category.show',
                'destroy' => 'web.category.destroy',
            ]);

    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('web.category.edit');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('web.category.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('web.category.destroy');

    Route::resource('tag', TagController::class)
            ->except(['destroy', 'edit', 'update'])
            ->names([
                'index' => 'web.tag.index',
                'create' => 'web.tag.create',
                'store' => 'web.tag.store',
                'show' => 'web.tag.show',
                'destroy' => 'web.tag.destroy',
            ]);

    Route::get('/tag/{tag}/edit', [TagController::class, 'edit'])->name('web.tag.edit');
    Route::put('/tag/{tag}', [TagController::class, 'update'])->name('web.tag.update');
    Route::delete('/tag/{tag}', [TagController::class, 'destroy'])->name('web.tag.destroy');

    // ── Categories ────────────────────────────────────────
    Route::resource('bm-category', BmCategoryController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names('web.bm-category');

    // Business mail Template
    Route::resource('bm-mail-template', BmMailTemplateController::class)
            ->names([
                'index' => 'web.bm-mail-template.index',
                'create' => 'web.bm-mail-template.create',
                'edit' => 'web.bm-mail-template.edit',
                'update' => 'web.bm-mail-template.update',
                'show' => 'web.bm-mail-template.show',
                'destroy' => 'web.bm-mail-template.destroy',
            ]);
    Route::post('templates/send-to-client', [BmMailTemplateController::class, 'sendToClient'])
             ->name('web.bm-mail-template.sendToClient');

    // Business mail Client
    Route::resource('bm-client', BmClientController::class)
            ->names([
                'index' => 'web.bm-client.index',
                'create' => 'web.bm-client.create',
                'edit' => 'web.bm-client.edit',
                'update' => 'web.bm-client.update',
                'show' => 'web.bm-client.show',
                'destroy' => 'web.bm-client.destroy',
            ]);

    // AJAX single send (called via fetch from modal)
    Route::post('clients/bulk-send', [BmClientController::class, 'bulkSend'])
             ->name('clients.bulkSend');


    // Business mail Logs
    Route::get('bm-mail-logs/export', [BmMailLogController::class, 'export'])->name('web.bm-logs.export');
    Route::get('bm-mail-logs',        [BmMailLogController::class, 'index']) ->name('web.bm-mail-logs.index');

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


Route::get('/test-mail', function () {
    try {
        Mail::raw('This is a test email from Laravel!', function ($message) {
            $message->to('gk@devotiontech.io')
                    ->subject('Test Email');
        });

        return '✅ Mail sent successfully!';
    } catch (\Exception $e) {
        return "❌ Mail Failed: " . $e->getMessage();
    }
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('news-analysis', [BlogsController::class, 'index'])->name('news.analysis');
Route::get('/blog/{slug}', [BlogsController::class, 'show']) ->name('blog.details');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/terms-and-conditions', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy-policy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/cookie-policy', [CookieController::class, 'index'])->name('cookie');
Route::get('/risk-disclosure', [RiskDisclosureController::class, 'index'])->name('risk-disclosure');
Route::get('/disclaimer', [DisclaimerController::class, 'index'])->name('disclaimer');


