<?php

use App\Services\LicenseService;

if (!function_exists('app_license_is_valid')) {
    function app_license_is_valid(): bool
    {
        return app(LicenseService::class)->isLicenseValid();
    }
}

if (!function_exists('app_is_installed')) {
    function app_is_installed(): bool
    {
        return app(LicenseService::class)->isInstalled();
    }
}
