<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LicenseService
{
    protected string $serverUrl;
    protected string $productId;
    protected string $appVersion;
    protected int $checkInterval;
    protected int $offlineGraceDays;
    protected int $requestTimeout;
    protected string $apiKey;

    public function __construct()
    {
        $this->serverUrl = config('license.license_server_url');
        $this->productId = config('license.product_id');
        $this->appVersion = config('license.app_version');
        $this->checkInterval = config('license.check_interval_days');
        $this->offlineGraceDays = config('license.offline_grace_days');
        $this->requestTimeout = config('license.request_timeout');
        $this->apiKey = config('license.api_key', '');
    }

    protected function apiHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (!empty($this->apiKey)) {
            $headers['X-API-Key'] = $this->apiKey;
        }

        return $headers;
    }

    public function getMachineId(): string
    {
        $parts = [
            PHP_OS,
            php_uname('n') ?: 'unknown',
            php_uname('m') ?: 'unknown',
            gethostname() ?: 'unknown',
        ];

        return hash_hmac('sha256', implode('|', $parts), 'product_inventory_machine_key');
    }

    public function getSiteUrl(): string
    {
        return parse_url(config('app.url'), PHP_URL_HOST) ?? 'localhost';
    }

    public function getAppUrl(): string
    {
        return config('app.url', 'http://localhost');
    }

    public function getServerIp(): string
    {
        return $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname()) ?? '127.0.0.1';
    }

    public function activateLicense(string $licenseKey): array
    {
        $url = $this->serverUrl . config('license.activation_endpoint');

        $payload = [
            'license_key' => $licenseKey,
            'site_url' => $this->getSiteUrl(),
            'app_url' => $this->getAppUrl(),
            'machine_id' => $this->getMachineId(),
            'server_ip' => $this->getServerIp(),
            'product_id' => $this->productId,
            'app_version' => $this->appVersion,
        ];

        Log::info('License activation attempted', [
            'url' => $url,
            'payload' => $payload,
        ]);

        try {
            Log::debug('License HTTP request starting', [
                'url' => $url,
                'method' => 'POST',
                'timeout' => $this->requestTimeout,
                'payload' => $payload,
            ]);

            $response = Http::timeout($this->requestTimeout)
                ->withHeaders($this->apiHeaders())
                ->retry(2, 500)
                ->post($url, $payload);

            Log::debug('License HTTP response received', [
                'url' => $url,
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {
                Log::warning('License activation failed - HTTP error', [
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                $errorMsg = 'Unable to contact license server. Please try again later.';
                if (config('app.debug')) {
                    $errorMsg .= ' (HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 200) . ')';
                }

                return ['success' => false, 'message' => $errorMsg];
            }

            $data = $response->json();

            if (!isset($data['status'])) {
                Log::warning('License activation failed - invalid response structure', [
                    'url' => $url,
                    'response_data' => $data,
                ]);

                return ['success' => false, 'message' => 'Invalid response from license server.'];
            }

            if ($data['status'] === 'active') {
                $cacheData = [
                    'license_key' => $data['license_key'] ?? $licenseKey,
                    'site_url' => $data['site_url'] ?? $this->getSiteUrl(),
                    'machine_id' => $data['machine_id'] ?? $this->getMachineId(),
                    'status' => 'active',
                    'expires_at' => $data['expires_at'] ?? null,
                    'last_check' => now()->toDateTimeString(),
                    'signature' => $data['signature'] ?? '',
                    'checksum' => '',
                ];

                $cacheData['checksum'] = $this->computeChecksum($cacheData);
                $this->writeLicenseCache($cacheData);

                Log::info('License activation successful', [
                    'license_key' => $this->maskKey($licenseKey),
                    'expires_at' => $cacheData['expires_at'],
                ]);

                return ['success' => true, 'message' => 'License activated successfully.'];
            }

            $messages = [
                'inactive' => 'This license key is inactive. Please contact the software provider.',
                'expired' => 'This license key has expired. Please contact the software provider.',
                'revoked' => 'This license key has been revoked. Please contact the software provider.',
            ];

            $message = $messages[$data['status']] ?? 'License verification failed. Please contact the software provider.';

            Log::warning('License activation failed', [
                'status' => $data['status'],
                'license_key' => $this->maskKey($licenseKey),
            ]);

            return ['success' => false, 'message' => $message];

        } catch (\Exception $e) {
            Log::error('License activation exception', [
                'url' => $url,
                'exception_class' => get_class($e),
                'error' => $e->getMessage(),
                'previous_exception' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null,
                'trace' => $e->getTraceAsString(),
            ]);

            $errorMsg = 'Unable to connect to license server. Please check your internet connection and try again.';
            if (config('app.debug')) {
                $errorMsg .= ' (Debug: ' . get_class($e) . ': ' . $e->getMessage() . ')';
            }

            return ['success' => false, 'message' => $errorMsg];
        }
    }

    public function checkLicense(): array
    {
        $cache = $this->readLicenseCache();

        if (!$cache) {
            Log::warning('License check failed - no cache found');

            return ['valid' => false, 'reason' => 'no_cache'];
        }

        if (!$this->validateCacheStructure($cache)) {
            Log::warning('License check failed - invalid cache structure (possible tampering)');
            $this->logTampering('invalid_structure');

            return ['valid' => false, 'reason' => 'tampered'];
        }

        if (!$this->validateCacheSignature($cache)) {
            Log::warning('License check failed - signature validation failed (possible tampering)');
            $this->logTampering('invalid_signature');

            return ['valid' => false, 'reason' => 'tampered'];
        }

        if (!isset($cache['status']) || $cache['status'] !== 'active') {
            Log::info('License check failed - status is not active', [
                'status' => $cache['status'] ?? 'unknown',
            ]);

            return ['valid' => false, 'reason' => 'inactive'];
        }

        if ($this->shouldRecheckRemote($cache)) {
            $remoteResult = $this->checkRemoteLicense($cache);

            if ($remoteResult === null) {
                if ($this->isWithinGracePeriod($cache)) {
                    Log::info('License remote check failed, using grace period');

                    return ['valid' => true, 'reason' => 'grace_period'];
                }

                Log::warning('License check failed - grace period exceeded');

                return ['valid' => false, 'reason' => 'grace_period_exceeded'];
            }

            if ($remoteResult === false) {
                return ['valid' => false, 'reason' => 'remote_inactive'];
            }

            $cache['last_check'] = now()->toDateTimeString();
            $cache['checksum'] = $this->computeChecksum($cache);
            $this->writeLicenseCache($cache);

            Log::info('License remote check successful');

            return ['valid' => true, 'reason' => 'verified'];
        }

        if ($this->isWithinGracePeriod($cache)) {
            return ['valid' => true, 'reason' => 'cache_valid'];
        }

        Log::warning('License check failed - stale cache, grace period exceeded');

        return ['valid' => false, 'reason' => 'stale_cache'];
    }

    protected function checkRemoteLicense(array $cache): ?bool
    {
        $url = $this->serverUrl . config('license.check_endpoint');

        $payload = [
            'license_key' => $cache['license_key'],
            'site_url' => $this->getSiteUrl(),
            'machine_id' => $this->getMachineId(),
            'product_id' => $this->productId,
            'app_version' => $this->appVersion,
        ];

        Log::info('Remote license check started', [
            'url' => $url,
            'payload' => $payload,
        ]);

        try {
            $response = Http::timeout(5)
                ->withHeaders($this->apiHeaders())
                ->retry(2, 1000)
                ->post($url, $payload);

            Log::debug('Remote license check response', [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {
                Log::warning('Remote license check failed - HTTP error', [
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }

            $data = $response->json();

            if (!isset($data['status'])) {
                Log::warning('Remote license check failed - invalid response', [
                    'url' => $url,
                    'response_data' => $data,
                ]);

                return null;
            }

            if ($data['status'] === 'active') {
                Log::info('Remote license check - license is active');
                return true;
            }

            $statuses = ['inactive', 'expired', 'revoked'];
            if (in_array($data['status'], $statuses)) {
                $updatedCache = [
                    'license_key' => $cache['license_key'],
                    'site_url' => $cache['site_url'],
                    'machine_id' => $cache['machine_id'],
                    'status' => $data['status'],
                    'expires_at' => $data['expires_at'] ?? $cache['expires_at'] ?? null,
                    'last_check' => now()->toDateTimeString(),
                    'signature' => $data['signature'] ?? $cache['signature'],
                    'checksum' => '',
                ];
                $updatedCache['checksum'] = $this->computeChecksum($updatedCache);
                $this->writeLicenseCache($updatedCache);

                Log::info('Remote license status updated', ['status' => $data['status']]);

                return false;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Remote license check exception', [
                'url' => $url,
                'exception_class' => get_class($e),
                'error' => $e->getMessage(),
                'previous_exception' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null,
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    public function isLicenseValid(): bool
    {
        $result = $this->checkLicense();

        return $result['valid'];
    }

    public function isInstalled(): bool
    {
        return file_exists(storage_path('app/' . config('license.installed_path')));
    }

    public function markInstalled(): bool
    {
        return touch(storage_path('app/' . config('license.installed_path')));
    }

    public function readLicenseCache(): ?array
    {
        $path = storage_path('app/' . config('license.cache_path'));

        if (!file_exists($path)) {
            return null;
        }

        try {
            $encrypted = file_get_contents($path);

            if (empty($encrypted)) {
                return null;
            }

            $decrypted = Crypt::decryptString($encrypted);

            $data = json_decode($decrypted, true);

            if (!is_array($data)) {
                return null;
            }

            return $data;

        } catch (\Exception $e) {
            Log::warning('Failed to read license cache', [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function writeLicenseCache(array $data): bool
    {
        try {
            $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $encrypted = Crypt::encryptString($json);
            $path = storage_path('app/' . config('license.cache_path'));

            return file_put_contents($path, $encrypted) !== false;

        } catch (\Exception $e) {
            Log::error('Failed to write license cache', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function validateCacheStructure(array $cache): bool
    {
        $required = ['license_key', 'site_url', 'machine_id', 'status', 'last_check'];

        foreach ($required as $key) {
            if (!array_key_exists($key, $cache) || $cache[$key] === null) {
                return false;
            }
        }

        if (!in_array($cache['status'], ['active', 'inactive', 'expired', 'revoked'])) {
            return false;
        }

        return true;
    }

    public function validateCacheSignature(array $cache): bool
    {
        if (empty($cache['checksum'])) {
            return false;
        }

        $expected = $this->computeChecksum($cache);

        return hash_equals($expected, $cache['checksum']);
    }

    public function shouldRecheckRemote(array $cache): bool
    {
        return true;
    }

    protected function isWithinGracePeriod(array $cache): bool
    {
        if (empty($cache['last_check'])) {
            return false;
        }

        $lastCheck = \Carbon\Carbon::parse($cache['last_check']);

        return $lastCheck->diffInDays(now()) <= $this->offlineGraceDays;
    }

    protected function computeChecksum(array $data): string
    {
        $payload = [
            'license_key' => $data['license_key'],
            'site_url' => $data['site_url'],
            'machine_id' => $data['machine_id'],
            'status' => $data['status'],
            'last_check' => $data['last_check'],
        ];

        ksort($payload);

        return hash_hmac('sha256', json_encode($payload), config('app.key'));
    }

    public function detectTampering(): bool
    {
        $cache = $this->readLicenseCache();

        if (!$cache) {
            return false;
        }

        if (!$this->validateCacheStructure($cache)) {
            return true;
        }

        if (!$this->validateCacheSignature($cache)) {
            return true;
        }

        return false;
    }

    public function logTampering(string $reason): void
    {
        Log::critical('LICENSE TAMPERING DETECTED', [
            'reason' => $reason,
            'site_url' => $this->getSiteUrl(),
            'machine_id' => $this->getMachineId(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    public function blockIfInvalid(): void
    {
        if (!$this->isLicenseValid()) {
            abort(redirect()->route('license-error'));
        }
    }

    protected function maskKey(string $key): string
    {
        if (strlen($key) <= 8) {
            return str_repeat('*', strlen($key));
        }

        return substr($key, 0, 4) . str_repeat('*', strlen($key) - 8) . substr($key, -4);
    }
}
