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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->comment('Unique identifier');
            $table->foreignId('parent_id')->nullable()->constrained('pages')->onDelete('set null')->comment('Parent page for hierarchy');
            $table->string('slug')->unique()->comment('URL slug');
            $table->string('template', 50)->default('default')->comment('Page template: default, landing, full-width');
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft')->comment('Page status');
            
            // Multilingual content (JSON)
            $table->json('title')->comment('Page title {"tr": "Başlık", "en": "Title"}');
            $table->json('excerpt')->nullable()->comment('Short description');
            
            // Media
            $table->unsignedBigInteger('featured_image_id')->nullable()->comment('Featured image (FK added later)');
            
            // Publishing
            $table->timestamp('published_at')->nullable()->comment('Publication date');
            $table->timestamp('scheduled_at')->nullable()->comment('Scheduled publication');
            $table->timestamp('expired_at')->nullable()->comment('Auto unpublish date');
            
            // Security
            $table->string('password')->nullable()->comment('Password protection');
            
            // Analytics
            $table->unsignedBigInteger('view_count')->default(0)->comment('Page view count');
            
            // Ordering
            $table->unsignedInteger('order')->default(0)->comment('Display order');
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Creator');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null')->comment('Last updater');
            
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('status');
            $table->index('template');
            $table->index('parent_id');
            $table->index('published_at');
            $table->index('scheduled_at');
            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
