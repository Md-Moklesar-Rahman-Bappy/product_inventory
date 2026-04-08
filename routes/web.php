<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ProductController,
    CategoryController,
    BrandController,
    AssetModelController,
    MaintenanceController,
    ActivityLogController,
    UserController,
    DashboardController,
    EmailVerificationController
};

// 🌐 Public Routes
Route::view('/', 'auth.login')->name('login');

// ✅ Public Email Verification Route
Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify.public');

// 🔐 Custom Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

// 🔐 Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // 📧 Email verification notice + resend
    Route::get('/email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');

    // 📊 Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 👤 Users
    Route::resource('users', UserController::class);
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // 📁 Categories
    Route::resource('categories', CategoryController::class);
    Route::get('categories/{id}/products', [CategoryController::class, 'products'])->name('categories.products');
    Route::get('category/{id}/products/export', [CategoryController::class, 'exportCategoryProducts'])->name('category.products.export');
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    // 🏷️ Brands
    Route::resource('brands', BrandController::class);
    Route::get('brands/{id}/products', [BrandController::class, 'products'])->name('brands.products');
    Route::post('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');

    // 🧩 Models
    Route::resource('models', AssetModelController::class);
    Route::get('models/{id}/products', [AssetModelController::class, 'products'])->name('models.products');
    Route::post('models/{id}/restore', [AssetModelController::class, 'restore'])->name('models.restore');
    Route::delete('models/{id}/force-delete', [AssetModelController::class, 'forceDelete'])->name('models.forceDelete');

    // 📦 Products Import/Export grouped
    Route::prefix('products')->group(function () {
        // Sample CSV download
        Route::get('sample', [ProductController::class, 'downloadSample'])->name('products.sample');

        // Import products
        Route::post('import', [ProductController::class, 'import'])->name('products.import');

        // 🚨 New route for exporting skipped rows
        Route::get('skipped/export', [ProductController::class, 'exportSkippedRows'])->name('products.skipped.export');

        // 🚨 New route for clearing skipped rows
        Route::post('skipped/clear', [ProductController::class, 'clearSkippedRows'])->name('products.skipped.clear');

        // Export products
        Route::prefix('export')->group(function () {
            Route::get('excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
            Route::get('category-wise', [ProductController::class, 'exportCategoryWise'])->name('products.export.category');
            Route::get('brand-wise/{id}', [ProductController::class, 'exportBrandWise'])->name('products.export.brand');
            Route::get('model-wise/{id}', [ProductController::class, 'exportModelWise'])->name('products.export.model');
        });
    });

    // 📦 Products resource routes
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    // 🛠️ Maintenance
    Route::resource('maintenance', MaintenanceController::class);
    Route::delete('maintenance/{id}/force-delete', [MaintenanceController::class, 'forceDelete'])->name('maintenance.forceDelete');

    // 📜 Activity Logs
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');

    // 🛡️ Warranty Overview
    Route::get('warranties', [ProductController::class, 'warranties'])->name('warranties.index');

    // 👤 Profile
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
});
