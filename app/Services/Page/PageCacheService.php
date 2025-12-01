<?php

namespace App\Services\Page;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageCacheService
{
    /**
     * Cache TTL in seconds (1 hour)
     */
    protected int $ttl = 3600;

    /**
     * Remember a value in cache
     */
    public function remember(string $key, int $ttl, callable $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Clear all cache for a page
     */
    public function clearPageCache(Page $page): void
    {
        $locales = array_keys(config('app.locales', ['en' => 'English', 'tr' => 'Türkçe']));

        // Clear page cache
        foreach ($locales as $locale) {
            Cache::forget("page.{$page->id}.{$locale}");
            Cache::forget("page.slug.{$page->slug}");
        }

        // Clear section cache
        foreach ($page->sections as $section) {
            foreach ($locales as $locale) {
                Cache::forget("section.{$section->id}.{$locale}");
            }
        }
    }

    /**
     * Clear all pages cache
     */
    public function clearAllPagesCache(): void
    {
        Cache::tags(['pages'])->flush();
    }

    /**
     * Warm up cache for a page
     */
    public function warmUp(Page $page): void
    {
        $locales = array_keys(config('app.locales', ['en' => 'English', 'tr' => 'Türkçe']));

        foreach ($locales as $locale) {
            app()->setLocale($locale);
            $this->remember("page.{$page->id}.{$locale}", $this->ttl, fn() => $page);
        }
    }
}
