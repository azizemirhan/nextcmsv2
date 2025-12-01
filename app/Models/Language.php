<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'flag',
        'direction',
        'is_default',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the default language
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    /**
     * Get active languages
     */
    public static function getActive()
    {
        return static::where('is_active', true)->orderBy('order')->get();
    }

    /**
     * Get language by code
     */
    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }

    /**
     * Check if RTL
     */
    public function isRtl(): bool
    {
        return $this->direction === 'rtl';
    }

    /**
     * Scope: only active
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
