<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    private const CACHE_KEY = 'website.settings.all';

    public function all()
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });
    }

    public function get($key, $default = null)
    {
        $settings = $this->all();
        return $settings[$key] ?? $default;
    }

    public function set(array $settings, string $group = 'general')
    {
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }

        $this->clearCache();
    }

    public function clearCache()
    {
        Cache::forget(self::CACHE_KEY);
    }
}
