<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('section_templates', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Section identifier: hero-banner-digital');
            $table->json('name')->comment('Display name {"tr": "Hero Banner", "en": ...}');
            $table->json('description')->nullable()->comment('Section description');
            $table->string('category', 50)->comment('Category: hero, content, cta, etc.');
            $table->string('icon', 100)->nullable()->comment('Icon class/name');
            $table->string('preview_image')->nullable()->comment('Preview image path');
            $table->string('view_path')->comment('Blade view path: frontend.sections._hero');
            $table->json('fields_schema')->comment('Field definitions (name, type, translatable, etc.)');
            $table->string('data_handler')->nullable()->comment('Handler class for dynamic data');
            $table->json('default_content')->nullable()->comment('Default section content');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->boolean('is_premium')->default(false)->comment('Premium section flag');
            $table->unsignedInteger('order')->default(0)->comment('Display order');
            $table->timestamps();

            // Indexes
            $table->index('key');
            $table->index('category');
            $table->index('is_active');
            $table->index(['category', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_templates');
    }
};
