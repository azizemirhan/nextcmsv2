<?php

use App\Services\Settings\SettingsService;

if (!function_exists('settings')) {
    /**
     * Get a setting value
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed|\App\Services\Settings\SettingsService
     */
    function settings(?string $key = null, $default = null)
    {
        $service = app(SettingsService::class);

        if ($key === null) {
            return $service;
        }

        return $service->get($key, $default);
    }
}

if (!function_exists('setting')) {
    /**
     * Alias for settings()
     */
    function setting(?string $key = null, $default = null)
    {
        return settings($key, $default);
    }
}
