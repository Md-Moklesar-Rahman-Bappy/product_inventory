<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            if (! $setting || is_null($setting->value) || $setting->value === '') {
                return $default;
            }

            return $setting->value;
        });
    }

    public static function set($key, $value, $type = 'text')
    {
        Cache::forget("setting_{$key}");

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    public static function allSettings()
    {
        return Cache::remember('settings_all', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function flushCache()
    {
        $keys = static::pluck('key')->toArray();
        foreach ($keys as $key) {
            Cache::forget("setting_{$key}");
        }
        Cache::forget('settings_all');
    }
}
