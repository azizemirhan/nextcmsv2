<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            $table->morphs('seoable');
            
            // Basic SEO
            $table->json('seo_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('focus_keyword')->nullable();
            $table->json('secondary_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            
            // Robots
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);
            $table->string('robots_advanced')->nullable();
            
            // Open Graph
            $table->json('og_title')->nullable();
            $table->json('og_description')->nullable();
            $table->foreignId('og_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('og_type')->default('website');
            
            // Twitter
            $table->json('twitter_title')->nullable();
            $table->json('twitter_description')->nullable();
            $table->foreignId('twitter_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('twitter_card_type')->default('summary_large_image');
            
            // Schema
            $table->string('schema_type')->nullable();
            $table->json('schema_data')->nullable();
            $table->boolean('auto_schema')->default(true);
            $table->text('manual_schema')->nullable();
            
            // Breadcrumbs
            $table->json('breadcrumb_title')->nullable();
            
            // Analysis
            $table->integer('seo_score')->nullable();
            $table->integer('readability_score')->nullable();
            $table->json('analysis_data')->nullable();
            $table->timestamp('last_analyzed_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
