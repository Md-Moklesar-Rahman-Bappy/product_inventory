<?php

namespace App\Http\Controllers;

use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LicenseManagementController extends Controller
{
    protected LicenseService $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    public function index()
    {
        $this->authorizeLicenseAccess();

        $cache = $this->licenseService->readLicenseCache();

        $info = [
            'installed' => $this->licenseService->isInstalled(),
            'cache_exists' => !is_null($cache),
            'license_key' => $cache['license_key'] ?? null,
            'masked_key' => $this->licenseService->getMaskedKey($cache['license_key'] ?? null),
            'status' => $cache['status'] ?? null,
            'site_url' => $cache['site_url'] ?? null,
            'machine_id' => $cache['machine_id'] ?? null,
            'expires_at' => $cache['expires_at'] ?? null,
            'last_check' => $cache['last_check'] ?? null,
            'server_url' => config('license.license_server_url'),
            'product_id' => config('license.product_id'),
            'app_version' => config('license.app_version'),
            'api_key_configured' => !empty(config('license.api_key')),
        ];

        return view('license-management.index', compact('info'));
    }

    public function refresh(Request $request)
    {
        $this->authorizeLicenseAccess();

        $result = $this->licenseService->refreshCache();

        ActivityLogController::logAction(
            'license-refresh',
            'License',
            0,
            '<span class="text-info fw-bold">Refreshed</span> local license cache. Result: ' . ($result['success'] ? 'success' : 'failed')
        );

        Log::info('License cache refresh requested by admin', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'success' => $result['success'],
            'message' => $result['message'],
        ]);

        if ($result['success']) {
            return redirect()->route('license-management.index')->with('success', $result['message']);
        }

        return redirect()->route('license-management.index')->with('error', $result['message']);
    }

    public function reactivate(Request $request)
    {
        $this->authorizeLicenseAccess();

        $result = $this->licenseService->reactivateLicense();

        ActivityLogController::logAction(
            'license-reactivate',
            'License',
            0,
            '<span class="text-warning fw-bold">Requested</span> reactivation of revoked license. Result: ' . ($result['success'] ? 'success' : 'failed')
        );

        Log::info('License reactivation requested by admin', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'success' => $result['success'],
            'message' => $result['message'],
        ]);

        if ($result['success']) {
            return redirect()->route('license-management.index')->with('success', $result['message']);
        }

        return redirect()->route('license-management.index')->with('error', $result['message']);
    }

    public function replace(Request $request)
    {
        $this->authorizeLicenseAccess();

        $request->validate([
            'replacement_license_key' => 'required|string|min:10',
        ]);

        $newKey = $request->input('replacement_license_key');

        $result = $this->licenseService->activateLicense($newKey);

        $masked = $this->licenseService->getMaskedKey($newKey);

        ActivityLogController::logAction(
            'license-replace',
            'License',
            0,
            '<span class="text-warning fw-bold">Applied</span> replacement license ' . e($masked) . '. Result: ' . ($result['success'] ? 'success' : 'failed')
        );

        Log::info('Replacement license applied by admin', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()?->email,
            'masked_key' => $masked,
            'success' => $result['success'],
        ]);

        if ($result['success']) {
            return redirect()->route('license-management.index')->with('success', 'Replacement license activated successfully.');
        }

        return redirect()->route('license-management.index')->with('error', 'License server rejected the request: ' . $result['message']);
    }

    protected function authorizeLicenseAccess(): void
    {
        $user = Auth::user();

        if (!$user instanceof \App\Models\User) {
            abort(403, 'You do not have permission.');
        }

        if (!$user->isSuperadmin() && !$user->isAdmin()) {
            abort(403, 'You do not have permission.');
        }
    }
}
