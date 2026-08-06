<?php

namespace App\Http\Middleware;

use App\Services\LicenseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyLicenseMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $licenseService = app(LicenseService::class);

        if (!$licenseService->isInstalled()) {
            return $next($request);
        }

        $path = $request->path();
        $routeName = $request->route()?->getName();

        $exemptRoutes = [
            'license-error',
            'login',
            'login.action',
            'logout',
            'register',
            'register.save',
            'verification.verify.public',
            'verification.notice',
            'verification.resend',
        ];

        if (in_array($routeName, $exemptRoutes)) {
            return $next($request);
        }

        // Admin license recovery page. Reachable only by an authenticated user;
        // the `auth` + `isAdmin` route middleware then enforces admin/superadmin
        // access (normal users receive 403). This exemption is required so that a
        // revoked license cannot lock authorized administrators out of the
        // recovery UI. It is NOT a license bypass: the page never marks a license
        // active on its own — every action re-verifies against the authoritative
        // license server first, and a revoked license stays revoked.
        if (str_starts_with($path, 'license-management')) {
            if (Auth::check()) {
                return $next($request);
            }

            return redirect()->route('license-error');
        }

        $exemptPaths = [
            'login',
            'logout',
            'register',
            'verify-email',
            'email',
            'license-error',
            'install',
        ];

        foreach ($exemptPaths as $exemptPath) {
            if (str_starts_with($path, $exemptPath)) {
                return $next($request);
            }
        }

        if ($this->isStaticAsset($request)) {
            return $next($request);
        }

        if ($licenseService->detectTampering()) {
            Log::critical('License tampering detected, blocking access', [
                'path' => $path,
                'ip' => $request->ip(),
            ]);

            return redirect()->route('license-error');
        }

        if (!$licenseService->isLicenseValid()) {
            Log::warning('Dashboard blocked due to invalid license', [
                'path' => $path,
                'ip' => $request->ip(),
            ]);

            return redirect()->route('license-error');
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

        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$/', $path)) {
            return true;
        }

        return false;
    }
}
