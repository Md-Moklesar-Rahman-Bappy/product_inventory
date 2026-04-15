<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'app_name', 'value' => 'Product Inventory', 'type' => 'text'],
            ['key' => 'website', 'value' => '', 'type' => 'text'],
            ['key' => 'phone', 'value' => '', 'type' => 'text'],
            ['key' => 'email', 'value' => '', 'type' => 'text'],
            ['key' => 'address', 'value' => '', 'type' => 'text'],
            ['key' => 'footer_credit', 'value' => 'DLRS SOCDS Project', 'type' => 'text'],
            ['key' => 'logo_path', 'value' => 'images/logo.svg', 'type' => 'image'],
            ['key' => 'favicon_path', 'value' => '', 'type' => 'image'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }
    }
}
