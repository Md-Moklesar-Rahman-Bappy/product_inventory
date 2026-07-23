<?php

use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsSuperadmin;
use App\Http\Middleware\ForcePasswordChange;
use App\Http\Middleware\InstalledMiddleware;
use App\Http\Middleware\VerifyLicenseMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            require base_path('routes/install.php');
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            EnsureUserIsActive::class,
            InstalledMiddleware::class,
            VerifyLicenseMiddleware::class,
            ForcePasswordChange::class,
        ]);

        $middleware->alias([
            'isAdmin' => EnsureUserIsAdmin::class,
            'isSuperadmin' => EnsureUserIsSuperadmin::class,
            'installed' => InstalledMiddleware::class,
            'verify.license' => VerifyLicenseMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {})
    ->create();
