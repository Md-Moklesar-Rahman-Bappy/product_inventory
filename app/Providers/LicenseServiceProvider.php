<?php

namespace App\Providers;

use App\Services\LicenseService;
use Illuminate\Support\ServiceProvider;

class LicenseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LicenseService::class, function ($app) {
            return new LicenseService();
        });
    }

    public function boot(): void
    {
        //
    }
}
