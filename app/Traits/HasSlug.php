<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait
     */
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateSlug();
            }
        });
    }

    /**
     * Generate unique slug
     */
    public function generateSlug(): string
    {
        $source = $this->getSlugSource();
        $slug = Str::slug($source);
        
        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    protected function slugExists(string $slug): bool
    {
        $query = static::where('slug', $slug);

        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }

    /**
     * Get the source for slug generation
     */
    protected function getSlugSource(): string
    {
        if (property_exists($this, 'slugSource')) {
            return $this->{$this->slugSource} ?? '';
        }

        // Try translatable title first
        if (method_exists($this, 'getTranslation')) {
            $title = $this->getTranslation('title', config('app.fallback_locale'));
            if ($title) {
                return $title;
            }
        }

        // Fallback to direct title attribute
        return $this->title ?? $this->name ?? 'item';
    }

    /**
     * Find model by slug
     */
    public static function findBySlug(string $slug)
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Find model by slug or fail
     */
    public static function findBySlugOrFail(string $slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }
}
