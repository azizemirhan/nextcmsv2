<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeo
{
    /**
     * Get SEO meta for this model (polymorphic)
     */
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(
            \App\Models\SeoMeta::class,
            'seoable'
        );
    }

    /**
     * Get SEO title (falls back to model title)
     */
    public function getSeoTitle(?string $locale = null): string
    {
        $seo = $this->seoMeta;
        
        if ($seo && $seo->seo_title) {
            return $seo->getTranslation('seo_title', $locale);
        }

        // Fallback to model title
        if (method_exists($this, 'getTranslation') && isset($this->translatable) && in_array('title', $this->translatable)) {
            return $this->getTranslation('title', $locale);
        }

        return $this->title ?? '';
    }

    /**
     * Get meta description
     */
    public function getMetaDescription(?string $locale = null): ?string
    {
        $seo = $this->seoMeta;
        
        if ($seo && $seo->meta_description) {
            return $seo->getTranslation('meta_description', $locale);
        }

        // Fallback to excerpt
        if (isset($this->excerpt)) {
            return $this->getTranslation('excerpt', $locale) ?? strip_tags($this->excerpt);
        }

        return null;
    }

    /**
     * Render meta tags for this model
     */
    public function renderMetaTags(): string
    {
        $seo = $this->seoMeta;
        
        if (!$seo) {
            return '';
        }

        $html = [];

        // Title
        $html[] = '<title>' . e($this->getSeoTitle()) . '</title>';

        // Meta description
        if ($description = $this->getMetaDescription()) {
            $html[] = '<meta name="description" content="' . e($description) . '">';
        }

        // Robots
        $robotsContent = [];
        if ($seo->robots_index) $robotsContent[] = 'index';
        else $robotsContent[] = 'noindex';
        
        if ($seo->robots_follow) $robotsContent[] = 'follow';
        else $robotsContent[] = 'nofollow';

        $html[] = '<meta name="robots" content="' . implode(',', $robotsContent) . '">';

        // Canonical
        if ($seo->canonical_url) {
            $html[] = '<link rel="canonical" href="' . e($seo->canonical_url) . '">';
        }

        // Open Graph
        if ($seo->og_title) {
            $html[] = '<meta property="og:title" content="' . e($seo->getTranslation('og_title')) . '">';
        }
        if ($seo->og_description) {
            $html[] = '<meta property="og:description" content="' . e($seo->getTranslation('og_description')) . '">';
        }
        if ($seo->og_image_id) {
            $ogImage = \App\Models\Media::find($seo->og_image_id);
            if ($ogImage) {
                $html[] = '<meta property="og:image" content="' . e($ogImage->getUrl()) . '">';
            }
        }

        // Twitter Card
        $html[] = '<meta name="twitter:card" content="' . e($seo->twitter_card_type) . '">';
        if ($seo->twitter_title) {
            $html[] = '<meta name="twitter:title" content="' . e($seo->getTranslation('twitter_title')) . '">';
        }

        return implode("\n", $html);
    }

    /**
     * Render JSON-LD schema
     */
    public function renderSchema(): ?string
    {
        $seo = $this->seoMeta;
        
        if (!$seo || !$seo->auto_schema) {
            return $seo->manual_schema ?? null;
        }

        // Auto-generate schema based on type
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $seo->schema_type ?? 'WebPage',
            'name' => $this->getSeoTitle(),
            'description' => $this->getMetaDescription(),
        ];

        if (isset($this->published_at)) {
            $schema['datePublished'] = $this->published_at->toIso8601String();
        }

        if (isset($this->updated_at)) {
            $schema['dateModified'] = $this->updated_at->toIso8601String();
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Create or update SEO meta
     */
    public function updateSeoMeta(array $data): void
    {
        $this->seoMeta()->updateOrCreate(
            ['seoable_id' => $this->id, 'seoable_type' => get_class($this)],
            $data
        );
    }
}
