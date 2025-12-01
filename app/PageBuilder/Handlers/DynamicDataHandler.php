<?php

namespace App\PageBuilder\Handlers;

use App\Models\PageSection;
use App\PageBuilder\Contracts\SectionHandlerInterface;

/**
 * Base handler for sections that need dynamic data
 */
class DynamicDataHandler implements SectionHandlerInterface
{
    /**
     * Handle section data
     */
    public function handle(array $content, PageSection $section): array
    {
        // Base implementation - can be extended by specific handlers
        return $content;
    }

    /**
     * Resolve dynamic placeholders in content
     */
    protected function resolvePlaceholders(string $text): string
    {
        $placeholders = [
            '{{site_name}}' => config('app.name'),
            '{{year}}' => date('Y'),
            '{{current_date}}' => now()->format('d M Y'),
        ];

        return str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            $text
        );
    }
}
