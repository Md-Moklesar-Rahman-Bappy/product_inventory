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

        // Set dynamic mail "from" address from settings
        if (Schema::hasTable('settings')) {
            $appName = Setting::get('app_name', config('app.name', 'Product Inventory'));
            $email = Setting::get('email', config('mail.from.address', 'noreply@example.com'));

            config([
                'mail.from.name' => $appName,
                'mail.from.address' => $email,
            ]);
        }
    }

    protected function configureSessionForInstall(): void
    {
        try {
            if (Schema::hasTable('sessions')) {
                return;
            }
            config(['session.driver' => 'file']);
        } catch (\Exception $e) {
            config(['session.driver' => 'file']);
        }
    }
}
