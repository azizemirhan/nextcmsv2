<?php

namespace App\Services\Settings;

use Illuminate\Support\Facades\Cache;

class SettingsCacheService
{
    protected string $cachePrefix = 'settings';
    protected int $cacheTtl = 86400; // 24 hours

    /**
     * Get cached setting
     */
    public function get(string $key, $default = null)
    {
        return Cache::get($this->getCacheKey($key), $default);
    }

    /**
     * Set cached setting
     */
    public function set(string $key, $value): void
    {
        Cache::put($this->getCacheKey($key), $value, $this->cacheTtl);
    }

    /**
     * Forget cached setting
     */
    public function forget(string $key): void
    {
        Cache::forget($this->getCacheKey($key));
    }

    /**
     * Clear all settings cache
     */
    public function flush(): void
    {
        Cache::tags($this->cachePrefix)->flush();
    }

    /**
     * Get cache key
     */
    protected function getCacheKey(string $key): string
    {
        return "{$this->cachePrefix}.{$key}";
    }

    /**
     * Get all cached settings
     */
    public function getAll(): array
    {
        return Cache::get("{$this->cachePrefix}.all", []);
    }

    /**
     * Set all settings in cache
     */
    public function setAll(array $settings): void
    {
        Cache::put("{$this->cachePrefix}.all", $settings, $this->cacheTtl);
    }
}
