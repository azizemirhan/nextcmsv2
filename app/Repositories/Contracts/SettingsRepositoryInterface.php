<?php

namespace App\Repositories\Contracts;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

interface SettingsRepositoryInterface
{
    /**
     * Get setting by key
     */
    public function get(string $key): ?Setting;

    /**
     * Get all settings in a group
     */
    public function getByGroup(string $groupKey): Collection;

    /**
     * Get all settings
     */
    public function all(): Collection;

    /**
     * Set a setting value
     */
    public function set(string $key, $value): bool;

    /**
     * Check if setting exists
     */
    public function has(string $key): bool;
}
