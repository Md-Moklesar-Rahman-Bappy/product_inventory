<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Notifications\SendCredentialsNotification;
use App\Http\Controllers\{
    AuthController,
    ProductController,
    CategoryController,
    BrandController,
    AssetModelController,
    MaintenanceController,
    ActivityLogController,
    UserController
};
use App\Models\{
    ActivityLog,
    Category,
    Brand,
    AssetModel,
    Product,
    Maintenance,
    User
};

// 🌐 Public Routes
Route::view('/', 'auth.login')->name('login');

// ✅ Public Email Verification Route (No login required)
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
                    '<span class="text-info fw-bold">Verified email</span> and sent credentials to user: <strong>' . e($user->name) . '</strong>'
                );
            } catch (\Exception $e) {
                Log::error('Credential decryption failed for user ID ' . $user->id, ['error' => $e->getMessage()]);
            }
        }
    }

    return redirect()->route('login')->with('message', '✅ Your email has been verified. Please check your inbox for login credentials.');
})->middleware('signed')->name('verification.verify.public');

// 🔐 Custom Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::post('logout', 'logout')->middleware('auth')->name('logout');
});

// 🔐 Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // 📧 Show verification notice
    Route::get('/email/verify', fn() => view('auth.verify'))->name('verification.notice');

    // 🔁 Resend verification email
    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '📧 Verification link sent!');
    })->name('verification.resend');

    // 📊 Dashboard
    Route::get('dashboard', function () {
    $logs = ActivityLog::with('user')->latest()->paginate(10);

    $entityCounts = [
        'Categories' => Category::count(),
        'Brands'     => Brand::count(),
        'Models'     => AssetModel::count(),
        'Products'   => Product::count(),
        'Maintenance' => Maintenance::count(),
        'Warranty'    => Product::whereNotNull('warranty_end')->count(),
    ];

    $now = Carbon::now();
    $soon = $now->copy()->addDays(30);

    $warrantyBreakdown = [
        'Active'        => Product::where('warranty_end', '>', $soon)->count(),
        'Expiring Soon' => Product::whereBetween('warranty_end', [$now, $soon])->count(),
        'Expired'       => Product::where('warranty_end', '<', $now)->count(),
    ];

    return view('dashboard', compact('logs', 'entityCounts', 'warrantyBreakdown'));
})->name('dashboard');



    // 👤 Users (Superadmin only)
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

    // 📦 Products
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');

    Route::prefix('products/export')->group(function () {
        Route::get('excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
        Route::get('category-wise', [ProductController::class, 'exportCategoryWise'])->name('products.export.category');
        Route::get('brand-wise/{id}', [ProductController::class, 'exportBrandWise'])->name('products.export.brand');
        Route::get('model-wise/{id}', [ProductController::class, 'exportModelWise'])->name('products.export.model');
    });

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
