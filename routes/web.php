<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AssetModelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\ActivityLog;
use App\Models\AssetModel;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Maintenance;
use App\Models\Product;
use App\Models\User;
use App\Notifications\SendCredentialsNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// 🌐 Public Routes
Route::view('/', 'auth.login')->name('login');

// ✅ Public Email Verification Route
Route::get('/verify-email/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));

        if ($user->shouldSendCredentials()) {
            try {
                $password = Crypt::decryptString($user->initial_password);
                $user->notify(new SendCredentialsNotification($password));

                $user->update([
                    'credentials_sent_at' => now(),
                    'initial_password' => null,
                ]);

                ActivityLogController::logAction(
                    'send-credentials',
                    'User',
                    $user->id,
                    '<span class="text-info fw-bold">Verified email</span> and sent credentials to user: <strong>'.e($user->name).'</strong>'
                );
            } catch (\Exception $e) {
                Log::error('Credential decryption failed for user ID '.$user->id, ['error' => $e->getMessage()]);
            }
        }
    }

    return redirect()->route('login')->with('success', 'Your email has been verified. Please check your inbox for login credentials.');
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
    Route::get('dashboard', function () {
        $logs = ActivityLog::with('user')->latest()->paginate(10);

        $entityCounts = [
            'Categories' => Category::count(),
            'Brands' => Brand::count(),
            'Models' => AssetModel::count(),
            'Products' => Product::count(),
            'Maintenance' => Maintenance::count(),
            'Warranty' => Product::whereNotNull('warranty_end')->count(),
        ];

        $now = Carbon::now();
        $soon = $now->copy()->addDays(30);

        $warrantyBreakdown = [
            'Active' => Product::where('warranty_end', '>', $soon)->count(),
            'Expiring Soon' => Product::whereBetween('warranty_end', [$now, $soon])->count(),
            'Expired' => Product::where('warranty_end', '<', $now)->count(),
        ];

        // Additional data for enhanced dashboard
        $recentProducts = Product::latest()->take(5)->get();
        $expiringWarranties = Product::whereBetween('warranty_end', [$now, $soon])->take(5)->get();
        $pendingMaintenance = Maintenance::where('end_time', '>', $now)->where('start_time', '<=', $now)->take(5)->get();

        // Product trend data (last 6 months)
        $productTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $productTrend[] = [
                'month' => $month->format('M'),
                'count' => Product::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->count(),
            ];
        }

        return view('dashboard', compact('logs', 'entityCounts', 'warrantyBreakdown', 'recentProducts', 'expiringWarranties', 'pendingMaintenance', 'productTrend'));
    })->name('dashboard');

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
    Route::post('categories/import', [CategoryController::class, 'import'])->name('categories.import');
    Route::get('categories/sample', [CategoryController::class, 'downloadSample'])->name('categories.sample');
    Route::get('categories/export', [CategoryController::class, 'export'])->name('categories.export');

    // 🏷️ Brands
    Route::resource('brands', BrandController::class);
    Route::get('brands/{id}/products', [BrandController::class, 'products'])->name('brands.products');
    Route::post('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');
    Route::post('brands/import', [BrandController::class, 'import'])->name('brands.import');
    Route::get('brands/sample', [BrandController::class, 'downloadSample'])->name('brands.sample');
    Route::get('brands/export', [BrandController::class, 'export'])->name('brands.export');

    // 🧩 Models
    Route::resource('models', AssetModelController::class);
    Route::get('models/{id}/products', [AssetModelController::class, 'products'])->name('models.products');
    Route::post('models/{id}/restore', [AssetModelController::class, 'restore'])->name('models.restore');
    Route::delete('models/{id}/force-delete', [AssetModelController::class, 'forceDelete'])->name('models.forceDelete');
    Route::post('models/import', [AssetModelController::class, 'import'])->name('models.import');
    Route::get('models/sample', [AssetModelController::class, 'downloadSample'])->name('models.sample');
    Route::get('models/export', [AssetModelController::class, 'export'])->name('models.export');

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

        // 🔍 AJAX Live Search
        Route::get('search', [ProductController::class, 'search'])->name('products.search');

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
    Route::get('maintenance/product/{serial}', [MaintenanceController::class, 'getProductBySerial'])->name('maintenance.getProductBySerial')->middleware('auth');

    // 📜 Activity Logs
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
    Route::get('activity-logs/product/{id}', [ActivityLogController::class, 'productLogs'])->name('activity.logs.product');
    Route::get('activity-logs/user/{id}', [ActivityLogController::class, 'userLogs'])->name('activity.logs.user');
    Route::get('activity-logs/model/{model}', [ActivityLogController::class, 'modelLogs'])->name('activity.logs.model');

    // 🛡️ Warranty Overview
    Route::get('warranties', [ProductController::class, 'warranties'])->name('warranties.index');

    // 👤 Profile
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile', [AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::post('password', [AuthController::class, 'passwordUpdate'])->name('password.update');
});
