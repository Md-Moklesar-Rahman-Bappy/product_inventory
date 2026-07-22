<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseActivation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LicenseApiController extends Controller
{
    public function activate(Request $request): JsonResponse
    {
        $request->validate([
            'license_key' => 'required|string',
            'site_url' => 'required|string',
            'app_url' => 'required|string',
            'machine_id' => 'required|string',
            'server_ip' => 'nullable|string',
            'product_id' => 'required|string',
            'app_version' => 'nullable|string',
        ]);

        $license = License::where('license_key', $request->license_key)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$license) {
            return response()->json([
                'status' => 'inactive',
                'message' => 'Invalid license key.',
            ], 404);
        }

        if ($license->status === 'revoked') {
            $this->logActivation($license, $request, 'failed', 'License is revoked.');

            return response()->json([
                'status' => 'revoked',
                'message' => 'This license has been revoked.',
            ], 403);
        }

        if ($license->status === 'expired' || ($license->expires_at && $license->expires_at->isPast())) {
            $license->update(['status' => 'expired']);
            $this->logActivation($license, $request, 'failed', 'License is expired.');

            return response()->json([
                'status' => 'expired',
                'message' => 'This license has expired.',
            ], 403);
        }

        if ($license->machine_id && $license->machine_id !== $request->machine_id) {
            $this->logActivation($license, $request, 'failed', 'Machine ID mismatch.');

            return response()->json([
                'status' => 'inactive',
                'message' => 'This license is bound to another machine.',
            ], 403);
        }

        $license->update([
            'site_url' => $request->site_url,
            'app_url' => $request->app_url,
            'machine_id' => $request->machine_id,
            'server_ip' => $request->server_ip ?? $license->server_ip,
            'status' => 'active',
            'activated_at' => now(),
            'last_check_at' => now(),
        ]);

        $this->logActivation($license, $request, 'success', 'License activated successfully.');

        $signature = $this->signResponse($license);

        return response()->json([
            'status' => 'active',
            'license_key' => $license->license_key,
            'site_url' => $license->site_url,
            'machine_id' => $license->machine_id,
            'expires_at' => $license->expires_at?->toDateTimeString(),
            'checked_at' => now()->toDateTimeString(),
            'signature' => $signature,
        ]);
    }

    public function check(Request $request): JsonResponse
    {
        $request->validate([
            'license_key' => 'required|string',
            'site_url' => 'required|string',
            'machine_id' => 'required|string',
            'product_id' => 'required|string',
            'app_version' => 'nullable|string',
        ]);

        $license = License::where('license_key', $request->license_key)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$license) {
            return response()->json([
                'status' => 'inactive',
                'message' => 'Invalid license key.',
            ], 404);
        }

        if ($license->status === 'revoked') {
            return response()->json([
                'status' => 'revoked',
                'message' => 'This license has been revoked.',
            ]);
        }

        if ($license->expires_at && $license->expires_at->isPast()) {
            $license->update(['status' => 'expired']);

            return response()->json([
                'status' => 'expired',
                'message' => 'This license has expired.',
            ]);
        }

        if ($license->machine_id !== $request->machine_id) {
            return response()->json([
                'status' => 'inactive',
                'message' => 'Machine ID mismatch.',
            ]);
        }

        $license->update(['last_check_at' => now()]);

        $signature = $this->signResponse($license);

        return response()->json([
            'status' => 'active',
            'license_key' => $license->license_key,
            'site_url' => $license->site_url,
            'machine_id' => $license->machine_id,
            'expires_at' => $license->expires_at?->toDateTimeString(),
            'checked_at' => now()->toDateTimeString(),
            'signature' => $signature,
        ]);
    }

    protected function signResponse(License $license): string
    {
        $payload = implode('|', [
            $license->license_key,
            $license->site_url ?? '',
            $license->machine_id ?? '',
            $license->status,
            $license->expires_at?->toDateTimeString() ?? '',
        ]);

        $secret = config('license_server.signing_secret');

        return hash_hmac('sha256', $payload, $secret);
    }

    protected function logActivation(License $license, Request $request, string $status, string $message): void
    {
        LicenseActivation::create([
            'license_id' => $license->id,
            'site_url' => $request->site_url,
            'app_url' => $request->app_url,
            'machine_id' => $request->machine_id,
            'server_ip' => $request->server_ip,
            'product_id' => $request->product_id,
            'app_version' => $request->app_version,
            'status' => $status,
            'message' => $message,
        ]);
    }
}
