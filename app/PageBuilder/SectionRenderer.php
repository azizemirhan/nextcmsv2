<?php

namespace App\PageBuilder;

use App\Models\PageSection;
use App\Models\SectionTemplate;
use App\PageBuilder\Contracts\SectionRendererInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SectionRenderer implements SectionRendererInterface
{
    /**
     * Render a page section
     */
    public function render(PageSection $section): string
    {
        try {
            // Check cache if TTL is set
            if ($section->cache_ttl && $section->cache_ttl > 0) {
                $cacheKey = "section.{$section->id}." . app()->getLocale();

                return Cache::remember($cacheKey, $section->cache_ttl, function () use ($section) {
                    return $this->renderSection($section);
                });
            }

            return $this->renderSection($section);
        } catch (\Exception $e) {
            Log::error("Section render error", [
                'section_id' => $section->id,
                'section_key' => $section->section_key,
                'error' => $e->getMessage()
            ]);

            if (config('app.debug')) {
                return "<!-- Section Render Error: {$e->getMessage()} -->";
            }

            return '';
        }
    }

    /**
     * Perform the actual rendering
     */
    protected function renderSection(PageSection $section): string
    {
        $template = $section->template;

        if (!$template) {
            Log::warning("Section template not found", [
                'section_key' => $section->section_key
            ]);
            return '';
        }

        if (!$template->view_path) {
            Log::warning("Section template view path not defined", [
                'section_key' => $section->section_key
            ]);
            return '';
        }

        // Resolve data (handle data handlers, translations)
        $data = $this->resolveData($section);

        // Check if view exists
        if (!View::exists($template->view_path)) {
            Log::warning("Section view not found", [
                'view_path' => $template->view_path
            ]);
            return '';
        }

        // Render the view
        return view($template->view_path, [
            'section' => $section,
            'content' => $data,
            'template' => $template,
        ])->render();
    }

    /**
     * Resolve section data with handlers and translations
     */
    public function resolveData(PageSection $section): array
    {
        $content = $section->content ?? [];
        $locale = app()->getLocale();

        // Get translated content
        $translatedContent = $this->getTranslatedContent($content, $locale);

        // If section has a data handler, execute it
        $template = $section->template;
        if ($template && $template->data_handler) {
            $translatedContent = $this->executeDataHandler(
                $template->data_handler,
                $translatedContent,
                $section
            );
        }

        return $translatedContent;
    }

    /**
     * Get translated content for current locale
     */
    public function getTranslatedContent(array $content, string $locale): array
    {
        $translated = [];

        foreach ($content as $key => $value) {
            if (is_array($value)) {
                // Check if it's a translatable field (has locale keys)
                if ($this->isTranslatableArray($value)) {
                    // Get value for current locale, fallback to default
                    $translated[$key] = $value[$locale]
                        ?? $value[config('app.fallback_locale')]
                        ?? $value[array_key_first($value)]
                        ?? '';
                } else {
                    // Recursively process nested arrays (like repeater fields)
                    $translated[$key] = array_map(function ($item) use ($locale) {
                        return is_array($item)
                            ? $this->getTranslatedContent($item, $locale)
                            : $item;
                    }, $value);
                }
            } else {
                $translated[$key] = $value;
            }
        }

        return $translated;
    }

    /**
     * Check if array is a translatable field
     */
    protected function isTranslatableArray(array $array): bool
    {
        $keys = array_keys($array);
        $locales = config('app.locales', ['en', 'tr']);

        // If all keys are locale codes, it's translatable
        return !empty($keys) && !empty(array_intersect($keys, array_keys($locales)));
    }

    /**
     * Execute data handler if exists
     */
    protected function executeDataHandler(string $handlerClass, array $content, PageSection $section): array
    {
        if (!class_exists($handlerClass)) {
            Log::warning("Data handler class not found", [
                'handler' => $handlerClass
            ]);
            return $content;
        }

        try {
            $handler = app($handlerClass);

            if (method_exists($handler, 'handle')) {
                return $handler->handle($content, $section);
            }

            Log::warning("Data handler missing handle method", [
                'handler' => $handlerClass
            ]);
        } catch (\Exception $e) {
            Log::error("Data handler execution error", [
                'handler' => $handlerClass,
                'error' => $e->getMessage()
            ]);
        }

        return $content;
    }

    /**
     * Clear cache for a section
     */
    public function clearCache(PageSection $section): void
    {
        $locales = array_keys(config('app.locales', ['en' => 'English', 'tr' => 'Türkçe']));

        foreach ($locales as $locale) {
            $cacheKey = "section.{$section->id}.{$locale}";
            Cache::forget($cacheKey);
        }
    }
}
