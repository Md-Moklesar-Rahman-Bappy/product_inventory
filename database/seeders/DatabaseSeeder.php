<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Note: Admin account is created through the installation wizard only.
     * No default test users should be seeded for security reasons.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
        ]);
    }
}
