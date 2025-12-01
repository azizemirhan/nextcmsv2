<?php

namespace App\Services\Settings;

use App\Models\Setting;
use App\Models\SettingsGroup;
use App\Repositories\SettingsRepository;
use Illuminate\Support\Collection;

class SettingsService
{
    public function __construct(
        protected SettingsRepository $repository,
        protected SettingsCacheService $cacheService
    ) {}

    /**
     * Get a setting value by key
     */
    public function get(string $key, $default = null, ?string $locale = null)
    {
        // Try cache first
        $cacheKey = $locale ? "{$key}.{$locale}" : $key;
        $cached = $this->cacheService->get($cacheKey);

        if ($cached !== null) {
            return $cached;
        }

        // Get from database
        $setting = $this->repository->get($key);

        if (!$setting) {
            return $default;
        }

        $value = $setting->getValue($locale);

        // Cache the value
        $this->cacheService->set($cacheKey, $value);

        return $value ?? $default;
    }

    /**
     * Set a setting value
     */
    public function set(string $key, $value): bool
    {
        $result = $this->repository->set($key, $value);

        if ($result) {
            // Clear cache
            $this->cacheService->forget($key);
            $this->clearAllCache();
        }

        return $result;
    }

    /**
     * Get all settings in a group
     */
    public function getGroup(string $groupKey): Collection
    {
        $cacheKey = "group.{$groupKey}";
        $cached = $this->cacheService->get($cacheKey);

        if ($cached) {
            return collect($cached);
        }

        $settings = $this->repository->getByGroup($groupKey);

        // Transform to key-value pairs
        $transformed = $settings->mapWithKeys(function ($setting) {
            return [$setting->key => $setting->getValue()];
        });

        $this->cacheService->set($cacheKey, $transformed->toArray());

        return $transformed;
    }

    /**
     * Get all settings as key-value pairs
     */
    public function all(): array
    {
        $cached = $this->cacheService->getAll();

        if (!empty($cached)) {
            return $cached;
        }

        $settings = $this->repository->all();

        $all = $settings->mapWithKeys(function ($setting) {
            return [$setting->key => $setting->getValue()];
        })->toArray();

        $this->cacheService->setAll($all);

        return $all;
    }

    /**
     * Check if setting exists
     */
    public function has(string $key): bool
    {
        return $this->repository->has($key);
    }

    /**
     * Clear all settings cache
     */
    public function clearCache(): void
    {
        $this->cacheService->flush();
    }

    /**
     * Clear cache for specific setting
     */
    protected function clearAllCache(): void
    {
        $this->cacheService->flush();
    }

    /**
     * Get all groups
     */
    public function getGroups(): Collection
    {
        return SettingsGroup::ordered()->get();
    }

    /**
     * Bulk update settings
     */
    public function bulkUpdate(array $data): bool
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }

        return true;
    }

    /**
     * Get setting by key with full model
     */
    public function getSetting(string $key): ?Setting
    {
        return $this->repository->get($key);
    }
}
