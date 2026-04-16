<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AssetModelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 🌐 Public Routes
Route::view('/', 'auth.login')->name('login');

// 🔐 Registration Routes (with rate limiting)
Route::middleware('throttle:5,10')->group(function () {
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerSave'])->name('register.save');
});

// ✅ Public Email Verification Route
Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(422, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));

        if ($user->shouldNotifyAccountCreated()) {
            $user->notifyAccountCreated();
        }
    }

    return redirect()->route('login')->with('success', 'Your email has been verified. Please use the password reset feature to set your password.');
})->middleware('signed')->name('verification.verify.public');

// 🔐 Custom Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->middleware('throttle:5,1')->name('login.action');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

// 🔐 Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // 📧 Email verification notice + resend
    Route::get('/email/verify', fn () => view('auth.verify'))->name('verification.notice');
    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', '📧 Verification link sent!');
    })->middleware('throttle:3,1')->name('verification.resend');

    // 📊 Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 👤 Users (Admin/Superadmin management)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore')->middleware('isSuperadmin');
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus')->middleware('isSuperadmin');
    });

    // 📁 Categories (Admin only)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::get('categories/{id}/products', [CategoryController::class, 'products'])->name('categories.products');
        Route::get('category/{id}/products/export', [CategoryController::class, 'exportCategoryProducts'])->name('category.products.export');
        Route::post('categories/import', [CategoryController::class, 'import'])->name('categories.import');
        Route::get('categories/sample', [CategoryController::class, 'downloadSample'])->name('categories.sample');
        Route::get('categories/export', [CategoryController::class, 'export'])->name('categories.export');
        Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    });
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete')->middleware(['auth', 'isSuperadmin']);

    // 🏷️ Brands (Admin only)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::resource('brands', BrandController::class)->except(['show']);
        Route::get('brands/{id}/products', [BrandController::class, 'products'])->name('brands.products');
        Route::post('brands/import', [BrandController::class, 'import'])->name('brands.import');
        Route::get('brands/sample', [BrandController::class, 'downloadSample'])->name('brands.sample');
        Route::get('brands/export', [BrandController::class, 'export'])->name('brands.export');
        Route::post('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    });
    Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete')->middleware(['auth', 'isSuperadmin']);

    // 🧩 Models (Admin only)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::resource('models', AssetModelController::class)->except(['show']);
        Route::get('models/{id}/products', [AssetModelController::class, 'products'])->name('models.products');
        Route::post('models/import', [AssetModelController::class, 'import'])->name('models.import');
        Route::get('models/sample', [AssetModelController::class, 'downloadSample'])->name('models.sample');
        Route::get('models/export', [AssetModelController::class, 'export'])->name('models.export');
        Route::post('models/{id}/restore', [AssetModelController::class, 'restore'])->name('models.restore');
    });
    Route::delete('models/{id}/force-delete', [AssetModelController::class, 'forceDelete'])->name('models.forceDelete')->middleware(['auth', 'isSuperadmin']);

    // 📦 Products Import/Export grouped (Admin only)
    Route::middleware(['auth', 'isAdmin'])->prefix('products')->group(function () {
        Route::get('sample', [ProductController::class, 'downloadSample'])->name('products.sample');
        Route::post('import', [ProductController::class, 'import'])->name('products.import')->middleware('throttle:10,1');
        Route::post('skipped/export', [ProductController::class, 'exportSkippedRows'])->name('products.skipped.export');
        Route::post('skipped/clear', [ProductController::class, 'clearSkippedRows'])->name('products.skipped.clear');
        Route::get('search', [ProductController::class, 'search'])->name('products.search');
        Route::prefix('export')->group(function () {
            Route::get('excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
            Route::get('category-wise', [ProductController::class, 'exportCategoryWise'])->name('products.export.category');
            Route::get('brand-wise/{id}', [ProductController::class, 'exportBrandWise'])->name('products.export.brand');
            Route::get('model-wise/{id}', [ProductController::class, 'exportModelWise'])->name('products.export.model');
        });
    });

    // 📦 Products resource routes (Admin only)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    });
    Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete')->middleware(['auth', 'isSuperadmin']);

    // 🛠️ Maintenance (Admin only)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::resource('maintenance', MaintenanceController::class)->except(['show']);
        Route::get('maintenance/product/{serial}', [MaintenanceController::class, 'getProductBySerial'])->name('maintenance.getProductBySerial');
    });
    Route::get('maintenance/{id}', [MaintenanceController::class, 'show'])->name('maintenance.show')->middleware('auth');

    // 📜 Activity Logs (Admin/Superadmin only)
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
        Route::get('activity-logs/product/{id}', [ActivityLogController::class, 'productLogs'])->name('activity.logs.product');
        Route::get('activity-logs/user/{id}', [ActivityLogController::class, 'userLogs'])->name('activity.logs.user');
        Route::get('activity-logs/model/{model}', [ActivityLogController::class, 'modelLogs'])->name('activity.logs.model');
    });

    // 🛡️ Warranty Overview
    Route::get('warranties', [ProductController::class, 'warranties'])->name('warranties.index');

    // 👤 Profile
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile', [AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::post('password', [AuthController::class, 'passwordUpdate'])->name('password.update');

    // ⚙️ Application Settings (Superadmin only)
    Route::middleware(['auth', 'isSuperadmin'])->prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/', [SettingController::class, 'update'])->name('settings.update');
    });
});
