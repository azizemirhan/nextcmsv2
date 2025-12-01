<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SectionTemplate extends Model
{
    use HasTranslations;

    protected $fillable = [
        'key',
        'name',
        'category',
        'description',
        'view_path',
        'fields_schema',
        'preview_image',
        'is_premium',
        'order',
        'data_handler',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'fields_schema' => 'array',
        'is_premium' => 'boolean',
        'order' => 'integer',
    ];

    protected $translatable = ['name', 'description'];

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeActive($query)
    {
        return $query->orderBy('order');
    }
}
