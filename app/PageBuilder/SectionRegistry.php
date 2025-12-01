<?php

namespace App\PageBuilder;

use App\Models\SectionTemplate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SectionRegistry
{
    /**
     * Cache key for sections
     */
    protected string $cacheKey = 'section_templates';

    /**
     * Cache TTL (1 day)
     */
    protected int $cacheTtl = 86400;

    /**
     * Get all section templates
     */
    public function all(): Collection
    {
        return Cache::remember($this->cacheKey . '.all', $this->cacheTtl, function () {
            return SectionTemplate::where('is_active', true)
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Get section templates by category
     */
    public function byCategory(string $category): Collection
    {
        return $this->all()->where('category', $category);
    }

    /**
     * Get section template by key
     */
    public function get(string $key): ?SectionTemplate
    {
        return Cache::remember("{$this->cacheKey}.{$key}", $this->cacheTtl, function () use ($key) {
            return SectionTemplate::where('key', $key)->first();
        });
    }

    /**
     * Get all categories
     */
    public function getCategories(): Collection
    {
        return $this->all()
            ->pluck('category')
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * Get sections grouped by category
     */
    public function grouped(): Collection
    {
        return $this->all()->groupBy('category');
    }

    /**
     * Check if section exists
     */
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * Register a new section template
     */
    public function register(array $data): SectionTemplate
    {
        $section = SectionTemplate::updateOrCreate(
            ['key' => $data['key']],
            $data
        );

        $this->clearCache();

        return $section;
    }

    /**
     * Unregister a section template
     */
    public function unregister(string $key): bool
    {
        $section = $this->get($key);

        if (!$section) {
            return false;
        }

        $result = $section->delete();
        $this->clearCache();

        return $result;
    }

    /**
     * Get field schema for a section
     */
    public function getFieldSchema(string $key): ?array
    {
        $section = $this->get($key);
        return $section?->fields_schema;
    }

    /**
     * Get view path for a section
     */
    public function getViewPath(string $key): ?string
    {
        $section = $this->get($key);
        return $section?->view_path;
    }

    /**
     * Get data handler for a section
     */
    public function getDataHandler(string $key): ?string
    {
        $section = $this->get($key);
        return $section?->data_handler;
    }

    /**
     * Clear section cache
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey . '.all');

        // Clear individual section caches
        $sections = SectionTemplate::pluck('key');
        foreach ($sections as $key) {
            Cache::forget("{$this->cacheKey}.{$key}");
        }
    }

    /**
     * Sync sections from config file
     */
    public function syncFromConfig(): int
    {
        $configSections = config('sections', []);
        $synced = 0;

        foreach ($configSections as $key => $config) {
            $data = [
                'key' => $key,
                'name' => $config['name'] ?? ['en' => $key],
                'description' => $config['description'] ?? null,
                'category' => $config['category'] ?? 'general',
                'icon' => $config['icon'] ?? null,
                'view_path' => $config['view'] ?? "frontend.sections.{$key}",
                'fields_schema' => $config['fields'] ?? [],
                'is_active' => true,
                'order' => $config['order'] ?? 0,
            ];

            $this->register($data);
            $synced++;
        }

        return $synced;
    }
}
