<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Creates the default superadmin account with documented credentials.
     * The user MUST change the password on first login.
     */
    public function run(): void
    {
        $this->createDefaultSuperadmin();
        $this->call([SettingSeeder::class]);
    }

    protected function createDefaultSuperadmin(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@superadmin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Password@123'),
                'permission' => 0,
                'utype' => 'SA',
                'status' => 'active',
                'email_verified_at' => now(),
                'force_password_change' => true,
            ]
        );
    }
}
