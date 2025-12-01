<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    use HasTranslations;

    protected $fillable = ['seoable_type', 'seoable_id', 'seo_title', 'meta_description', 'focus_keyword', 'secondary_keywords', 'canonical_url', 'robots_index', 'robots_follow', 'robots_advanced', 'og_title', 'og_description', 'og_image_id', 'og_type', 'twitter_title', 'twitter_description', 'twitter_image_id', 'twitter_card_type', 'schema_type', 'schema_data', 'auto_schema', 'manual_schema', 'breadcrumb_title', 'seo_score', 'readability_score', 'analysis_data', 'last_analyzed_at'];
    protected $casts = ['seo_title' => 'array', 'meta_description' => 'array', 'focus_keyword' => 'array', 'secondary_keywords' => 'array', 'og_title' => 'array', 'og_description' => 'array', 'twitter_title' => 'array', 'twitter_description' => 'array', 'schema_data' => 'array', 'analysis_data' => 'array', 'robots_index' => 'boolean', 'robots_follow' => 'boolean', 'auto_schema' => 'boolean', 'last_analyzed_at' => 'datetime'];
    protected $translatable = ['seo_title', 'meta_description', 'focus_keyword', 'og_title', 'og_description', 'twitter_title', 'twitter_description', 'breadcrumb_title'];

    public function seoable()
    {
        return $this->morphTo();
    }
}
