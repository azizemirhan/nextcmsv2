<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SettingsGroup extends Model
{
    use HasTranslations;

    protected $fillable = [
        'key',
        'name',
        'description',
        'icon',
        'order',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'order' => 'integer',
    ];

    protected $translatable = ['name', 'description'];

    /**
     * Get all settings in this group
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class, 'group_id')->orderBy('order');
    }

    /**
     * Scope to order by order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
