<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class InstallController extends Controller
{
    protected LicenseService $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    public function requirements()
    {
        if ($this->licenseService->isInstalled()) {
            return redirect()->route('dashboard');
        }

        $requirements = $this->checkRequirements();

        return view('install.requirements', compact('requirements'));
    }

    public function database()
    {
        if ($this->licenseService->isInstalled()) {
            return redirect()->route('dashboard');
        }

        $envPath = base_path('.env');
        $existingConfig = [];

        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
            $existingConfig = [
                'host' => $this->extractEnvValue($envContent, 'DB_HOST') ?? '127.0.0.1',
                'port' => $this->extractEnvValue($envContent, 'DB_PORT') ?? '3306',
                'database' => $this->extractEnvValue($envContent, 'DB_DATABASE') ?? '',
                'username' => $this->extractEnvValue($envContent, 'DB_USERNAME') ?? '',
                'password' => $this->extractEnvValue($envContent, 'DB_PASSWORD') ?? '',
            ];
        }

        return view('install.database', ['existingConfig' => $existingConfig]);
    }

    public function databaseStore(Request $request)
    {
        if ($this->licenseService->isInstalled()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'host' => 'required|string|max:255',
            'port' => 'required|numeric|min:1|max:65535',
            'database' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
        ]);

        try {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $request->host,
                $request->port,
                $request->database
            );

            $pdo = new \PDO($dsn, $request->username, $request->password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_TIMEOUT => 5,
            ]);

            $pdo = null;

            Log::info('Database connection test successful', [
                'host' => $request->host,
                'database' => $request->database,
            ]);

        } catch (\Exception $e) {
            Log::warning('Database connection test failed', [
                'host' => $request->host,
                'database' => $request->database,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'database' => 'Database connection failed: ' . $e->getMessage(),
            ])->withInput();
        }

        $this->updateEnvFile([
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $request->host,
            'DB_PORT' => $request->port,
            'DB_DATABASE' => $request->database,
            'DB_USERNAME' => $request->username,
            'DB_PASSWORD' => $request->password,
        ]);

        session(['install_database' => true]);

        return redirect()->route('install.license');
    }

    public function license()
    {
        if ($this->licenseService->isInstalled()) {
            return redirect()->route('dashboard');
        }

        if (!session('install_database')) {
            return redirect()->route('install.database');
        }

        return view('install.license');
    }

    public function licenseActivate(Request $request)
    {
        if ($this->licenseService->isInstalled()) {
            return redirect()->route('dashboard');
        }

        if (!session('install_database')) {
            return redirect()->route('install.database');
        }

        $request->validate([
            'license_key' => 'required|string|min:10',
        ]);

        $result = $this->licenseService->activateLicense($request->license_key);

        Log::info('Activation attempted during installation', [
            'success' => $result['success'],
        ]);

        if (!$result['success']) {
            return back()->withErrors([
                'license_key' => $result['message'],
            ])->withInput();
        }

        session(['install_license' => true, 'license_key' => $request->license_key]);

        return redirect()->route('install.admin');
    }

    public function admin()
    {
        if ($this->licenseService->isInstalled()) {
            return redirect()->route('dashboard');
        }

        if (!session('install_database') || !session('install_license')) {
            return redirect()->route('install.requirements');
        }

        return view('install.admin');
    }

    public function adminStore(Request $request)
    {
        if ($this->licenseService->isInstalled()) {
            return redirect()->route('dashboard');
        }

        if (!session('install_database') || !session('install_license')) {
            return redirect()->route('install.requirements');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*]/',
            ],
        ], [
            'password.regex' => 'Password must contain at least: 1 uppercase, 1 lowercase, 1 number, and 1 special character (!@#$%^&*)',
        ]);

        try {
            Artisan::call('migrate', ['--force' => true]);

            try {
                Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\SettingSeeder', '--force' => true]);
            } catch (\Exception $seedEx) {
                Log::info('Seeder skipped: ' . $seedEx->getMessage());
            }

            try {
                Artisan::call('storage:link');
            } catch (\Exception $e) {
                Log::info('Storage link: ' . $e->getMessage());
            }

            try {
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
            } catch (\Exception $e) {
                Log::info('Cache cleared: ' . $e->getMessage());
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->permission = 0;
            $user->utype = 'SA';
            $user->status = 'active';
            $user->email_verified_at = now();
            $user->save();

            Log::info('Super admin created during installation', [
                'email' => $request->email,
            ]);

            $this->licenseService->markInstalled();

            session()->forget(['install_database', 'install_license', 'license_key']);

            Log::info('Installation completed successfully');

            return redirect()->route('install.complete');

        } catch (\Exception $e) {
            Log::error('Installation failed at admin creation', [
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'installation' => 'Installation failed: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function complete()
    {
        if (!$this->licenseService->isInstalled()) {
            return redirect()->route('install.requirements');
        }

        return view('install.complete');
    }

    protected function checkRequirements(): array
    {
        $requirements = [];

        $requirements[] = [
            'name' => 'PHP Version >= 8.2',
            'passed' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'current' => PHP_VERSION,
        ];

        $requiredExtensions = ['mbstring', 'openssl', 'pdo', 'pdo_mysql', 'curl', 'json', 'fileinfo', 'gd', 'xml', 'zip', 'bcmath', 'tokenizer'];
        foreach ($requiredExtensions as $ext) {
            $requirements[] = [
                'name' => "PHP Extension: {$ext}",
                'passed' => extension_loaded($ext),
                'current' => extension_loaded($ext) ? 'Loaded' : 'Not Loaded',
            ];
        }

        $requirements[] = [
            'name' => 'storage/app writable',
            'passed' => is_writable(storage_path('app')),
            'current' => is_writable(storage_path('app')) ? 'Yes' : 'No',
        ];

        $requirements[] = [
            'name' => 'bootstrap/cache writable',
            'passed' => is_writable(base_path('bootstrap/cache')),
            'current' => is_writable(base_path('bootstrap/cache')) ? 'Yes' : 'No',
        ];

        $requirements[] = [
            'name' => 'storage/logs writable',
            'passed' => is_writable(storage_path('logs')),
            'current' => is_writable(storage_path('logs')) ? 'Yes' : 'No',
        ];

        $envPath = base_path('.env');
        $envWritable = file_exists($envPath) ? is_writable($envPath) : is_writable(base_path());
        $requirements[] = [
            'name' => '.env file writable or creatable',
            'passed' => $envWritable,
            'current' => $envWritable ? 'Yes' : 'No',
        ];

        $requirements[] = [
            'name' => 'APP_KEY configured',
            'passed' => !empty(env('APP_KEY', config('app.key'))),
            'current' => !empty(env('APP_KEY', config('app.key'))) ? 'Set' : 'Not Set',
        ];

        return $requirements;
    }

    protected function updateEnvFile(array $values): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            $envExamplePath = base_path('.env.example');
            if (file_exists($envExamplePath)) {
                copy($envExamplePath, $envPath);
            } else {
                file_put_contents($envPath, '');
            }
        }

        $envContent = file_get_contents($envPath);

        foreach ($values as $key => $value) {
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);

        if (empty(config('app.key'))) {
            Artisan::call('key:generate', ['--force' => true]);
        }

        config(['database.default' => $values['DB_CONNECTION'] ?? 'mysql']);
    }

    protected function extractEnvValue(string $content, string $key): ?string
    {
        if (preg_match("/^{$key}=(.*)$/m", $content, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }
}
