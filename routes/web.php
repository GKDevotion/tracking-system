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
use App\Http\Controllers\EducationController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RiskDisclosureController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\Web\AdminUserController;
use App\Http\Controllers\Web\BannersController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\TagController;
use App\Http\Controllers\Web\TrackingController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\ConfigurationController;
use App\Http\Controllers\Web\CountryController;
use App\Http\Controllers\Web\ManagerUserController;
use App\Http\Controllers\Web\PlanController;
use App\Http\Controllers\Web\PricingPlanCheckoutController;
use App\Http\Controllers\Web\SalesUserController;
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
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('web.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('web.dashboard.index');

    // Change Password
    Route::get('/change-password', [AuthController::class, 'changePasswordForm'])->name('web.change.password.form');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('web.change.password');

    // Roles
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

    // Sales User
    Route::resource('sales-user', SalesUserController::class)
            ->names([
                'index' => 'web.sales-user.index',
                'create' => 'web.sales-user.create',
                'edit' => 'web.sales-user.edit',
                'update' => 'web.sales-user.update',
                'show' => 'web.sales-user.show',
            ]);

    // Manager User
    Route::resource('manager-user', ManagerUserController::class)
            ->names([
                'index' => 'web.manager-user.index',
                'create' => 'web.manager-user.create',
                'edit' => 'web.manager-user.edit',
                'update' => 'web.manager-user.update',
                'show' => 'web.manager-user.show',
            ]);

    // Admin User
    Route::resource('admin-user', AdminUserController::class)
            ->names([
                'index' => 'web.admin-user.index',
                'create' => 'web.admin-user.create',
                'edit' => 'web.admin-user.edit',
                'update' => 'web.admin-user.update',
                'show' => 'web.admin-user.show',
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
    Route::resource('blogs', BlogController::class)
            ->names([
                'index' => 'web.blogs.index',
                'create' => 'web.blogs.create',
                'store' => 'web.blogs.store',
                'edit' => 'web.blogs.edit',
                'update' => 'web.blogs.update',
                'destroy' => 'web.blogs.destroy',
                'show' => 'web.blogs.show',
            ]);

    // Banner
    Route::resource('banners', BannersController::class)
            ->names([
                'index' => 'web.banners.index',
                'create' => 'web.banners.create',
                'store' => 'web.banners.store',
                'edit' => 'web.banners.edit',
                'update' => 'web.banners.update',
                'destroy' => 'web.banners.destroy',
                'show' => 'web.banners.show',
            ]);

    // Country
    Route::resource('country', CountryController::class)
            ->names([
                'index' => 'web.country.index',
                'create' => 'web.country.create',
                'store' => 'web.country.store',
                'edit' => 'web.country.edit',
                'update' => 'web.country.update',
                'destroy' => 'web.country.destroy',
                'show' => 'web.country.show',
            ]);

    // Tracking
    Route::resource('tracking', TrackingController::class)
            ->names([
                'index' => 'web.tracking.index',
                'create' => 'web.tracking.create',
                'store' => 'web.tracking.store',
                'show' => 'web.tracking.show',
                'update' =>  'web.tracking.update',
                'destroy'   =>  'web.tracking.destroy'
            ]);
     // Blog Category
    Route::resource('blog-category', CategoryController::class)
            ->names([
                'index' => 'web.blog-category.index',
                'create' => 'web.blog-category.create',
                'store' => 'web.blog-category.store',
                'show' => 'web.blog-category.show',
                'edit' => 'web.blog-category.edit',
                'update' => 'web.blog-category.update',
                'destroy' => 'web.blog-category.destroy',
            ]);
    // Blog Tag
    Route::resource('blog-tag', TagController::class)
            ->names([
                'index' => 'web.blog-tag.index',
                'create' => 'web.blog-tag.create',
                'store' => 'web.blog-tag.store',
                'show' => 'web.blog-tag.show',
                'edit' => 'web.blog-tag.edit',
                'update' => 'web.blog-tag.update',
                'destroy' => 'web.blog-tag.destroy',
            ]);

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

// frontend routes

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

Route::get('/education', [EducationController::class, 'index'])->name('education');
