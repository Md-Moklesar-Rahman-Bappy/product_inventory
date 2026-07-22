<?php

namespace App\Http\Middleware;

use App\Services\LicenseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstalledMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $licenseService = app(LicenseService::class);
        $isInstalled = $licenseService->isInstalled();
        $path = $request->path();
        $routeName = $request->route()?->getName();

        $installPaths = [
            'install',
            'install/requirements',
            'install/database',
            'install/license',
            'install/admin',
            'install/complete',
        ];

        $isInstallRoute = in_array($path, $installPaths)
            || str_starts_with($path, 'install/')
            || $routeName === 'license-error';

        if (!$isInstalled) {
            if ($isInstallRoute || $this->isStaticAsset($request)) {
                return $next($request);
            }

            return redirect()->route('install.requirements');
        }

        if ($isInstalled && $isInstallRoute && $routeName !== 'license-error') {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }

    protected function isStaticAsset(Request $request): bool
    {
        $path = $request->path();

        $staticPrefixes = [
            'css/',
            'js/',
            'images/',
            'favicon.ico',
            'robots.txt',
            'storage/',
        ];

        foreach ($staticPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        if (str_ends_with($path, '.css') || str_ends_with($path, '.js') || str_ends_with($path, '.png') || str_ends_with($path, '.jpg') || str_ends_with($path, '.svg') || str_ends_with($path, '.ico')) {
            return true;
        }

        return false;
    }
}
