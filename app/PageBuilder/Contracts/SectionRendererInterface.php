<?php

namespace App\PageBuilder\Contracts;

use App\Models\PageSection;

interface SectionRendererInterface
{
    /**
     * Render a page section
     */
    public function render(PageSection $section): string;

    /**
     * Resolve section data with handlers
     */
    public function resolveData(PageSection $section): array;

    /**
     * Get translated content for current locale
     */
    public function getTranslatedContent(array $content, string $locale): array;
}
