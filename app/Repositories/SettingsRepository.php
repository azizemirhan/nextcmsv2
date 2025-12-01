<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Contracts\SettingsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SettingsRepository implements SettingsRepositoryInterface
{
    /**
     * Get setting by key
     */
    public function get(string $key): ?Setting
    {
        return Setting::where('key', $key)->first();
    }

    /**
     * Get all settings in a group
     */
    public function getByGroup(string $groupKey): Collection
    {
        return Setting::inGroup($groupKey)
            ->ordered()
            ->get();
    }

    /**
     * Get all settings
     */
    public function all(): Collection
    {
        return Setting::with('group')
            ->ordered()
            ->get();
    }

    /**
     * Set a setting value
     */
    public function set(string $key, $value): bool
    {
        $setting = $this->get($key);

        if (!$setting) {
            return false;
        }

        $setting->setValue($value);
        return $setting->save();
    }

    /**
     * Check if setting exists
     */
    public function has(string $key): bool
    {
        return Setting::where('key', $key)->exists();
    }
}
