<?php

use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'installed'])->prefix('install')->name('install.')->group(function () {
    Route::get('/', [InstallController::class, 'requirements'])->name('requirements');
    Route::get('/requirements', function () {
        return redirect()->route('install.requirements');
    });
    Route::get('/database', [InstallController::class, 'database'])->name('database');
    Route::post('/database', [InstallController::class, 'databaseStore'])->name('database.store');
    Route::get('/license', [InstallController::class, 'license'])->name('license');
    Route::post('/license', [InstallController::class, 'licenseActivate'])->name('license.activate');
    Route::get('/admin', [InstallController::class, 'admin'])->name('admin');
    Route::post('/admin', [InstallController::class, 'adminStore'])->name('admin.store');
    Route::get('/complete', [InstallController::class, 'complete'])->name('complete');
});

Route::middleware(['web'])->get('/license-error', function () {
    return view('license-error');
})->name('license-error');
