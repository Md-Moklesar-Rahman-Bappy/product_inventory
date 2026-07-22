<?php

use App\Http\Controllers\AdminLicenseController;
use App\Http\Controllers\LicenseApiController;
use Illuminate\Support\Facades\Route;

// Public API routes (no auth required)
Route::post('/api/license/activate', [LicenseApiController::class, 'activate']);
Route::post('/api/license/check', [LicenseApiController::class, 'check']);

// Admin routes (auth required)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/licenses', [AdminLicenseController::class, 'index'])->name('licenses.index');
    Route::get('/licenses/create', [AdminLicenseController::class, 'create'])->name('licenses.create');
    Route::post('/licenses', [AdminLicenseController::class, 'store'])->name('licenses.store');
    Route::get('/licenses/{license}', [AdminLicenseController::class, 'show'])->name('licenses.show');
    Route::put('/licenses/{license}/status', [AdminLicenseController::class, 'updateStatus'])->name('licenses.updateStatus');
    Route::post('/licenses/{license}/reset', [AdminLicenseController::class, 'resetBinding'])->name('licenses.reset');
    Route::delete('/licenses/{license}', [AdminLicenseController::class, 'destroy'])->name('licenses.destroy');
});
