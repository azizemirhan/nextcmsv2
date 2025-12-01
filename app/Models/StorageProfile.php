<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageProfile extends Model
{
    protected $fillable = [
        'name',
        'driver',
        'config',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
