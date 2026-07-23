<?php

namespace App\Http\Middleware;

use App\Services\LicenseService;
use Closure;
use Illuminate\Http\Request;
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
            'password.forgot',
            'password.forgot.email.form',
            'password.forgot.email.send',
            'password.forgot.phone.form',
            'password.forgot.phone.send',
            'password.forgot.otp.form',
            'password.forgot.otp.verify',
            'password.forgot.reset.form',
            'password.forgot.reset.update',
        ];

        if (in_array($routeName, $exemptRoutes)) {
            return $next($request);
        }

        $exemptPaths = [
            'login',
            'logout',
            'register',
            'verify-email',
            'email',
            'license-error',
            'install',
            'forgot-password',
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
