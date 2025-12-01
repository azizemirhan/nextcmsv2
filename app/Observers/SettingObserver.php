<?php

namespace App\Observers;

use App\Models\Setting;
use App\Services\Settings\SettingsCacheService;

class SettingObserver
{
    public function __construct(
        protected SettingsCacheService $cacheService
    ) {}

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        $this->clearCache($setting);
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        $this->clearCache($setting);
    }

    /**
     * Clear cache for the setting
     */
    protected function clearCache(Setting $setting): void
    {
        $this->cacheService->forget($setting->key);
        $this->cacheService->flush();
    }
}
