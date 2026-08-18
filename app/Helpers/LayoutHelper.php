<?php

use App\Services\SettingService;
use App\Services\NavigationService;
use Illuminate\Support\Facades\App;

if (!function_exists('setting')) {
    /**
     * Get a website setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return App::make(SettingService::class)->get($key, $default);
    }
}

if (!function_exists('menu')) {
    /**
     * Get active navigation menu items for a specific location.
     *
     * @param string $location
     * @return \Illuminate\Support\Collection
     */
    function menu($location)
    {
        return App::make(NavigationService::class)->getMenu($location);
    }
}

if (!function_exists('log_activity')) {
    /**
     * Helper to easily log activities.
     *
     * @param string $action
     * @param mixed $subject
     * @param array $metadata
     * @param string|null $description
     * @return \App\Models\ActivityLog
     */
    function log_activity(string $action, $subject = null, array $metadata = [], ?string $description = null)
    {
        return app(\App\Services\ActivityLogger::class)->log($action, $subject, $metadata, $description);
    }
}
