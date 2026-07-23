<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Policies\BrandPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Services\LicenseService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LicenseService::class, function ($app) {
            return new LicenseService();
        });
    }

    public function boot(): void
    {
        $this->configureSessionForInstall();

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Brand::class, BrandPolicy::class);

        Paginator::defaultView('vendor.pagination.bootstrap-5');
        Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-5');

        $this->configureMailFromSettings();
    }

    protected function configureSessionForInstall(): void
    {
        try {
            if (!config('database.default')) {
                config(['session.driver' => 'file']);
                return;
            }

            $connection = config('database.connections.' . config('database.default'));
            if (!$connection) {
                config(['session.driver' => 'file']);
                return;
            }

            if (config('database.default') === 'sqlite') {
                $dbPath = $connection['database'] ?? '';
                if ($dbPath && !file_exists($dbPath)) {
                    config(['session.driver' => 'file']);
                    return;
                }
            }

            if (Schema::hasTable('sessions')) {
                return;
            }
            config(['session.driver' => 'file']);
        } catch (\Exception $e) {
            config(['session.driver' => 'file']);
        }
    }

    protected function configureMailFromSettings(): void
    {
        try {
            $connection = config('database.default');

            if ($connection === 'sqlite') {
                $dbPath = config("database.connections.sqlite.database", '');
                if ($dbPath && !file_exists($dbPath)) {
                    return;
                }
            }

            if (!Schema::hasTable('settings')) {
                return;
            }

            $appName = Setting::get('app_name');
            $email = Setting::get('email');

            if ($appName !== null && $appName !== '') {
                config(['mail.from.name' => $appName]);
            }

            if ($email !== null && $email !== '') {
                config(['mail.from.address' => $email]);
            }
        } catch (\Exception $e) {
            // Silently skip during install, migrate, or when DB is not ready
        }
    }
}
