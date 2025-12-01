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
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->comment('Unique identifier');
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade')->comment('Parent page');
            $table->string('section_key')->comment('Section template key reference');
            $table->json('content')->comment('Section content data (multilingual)');
            $table->unsignedInteger('order')->default(0)->comment('Display order');
            $table->boolean('is_active')->default(true)->comment('Active status (ON/OFF toggle)');
            $table->foreignId('copied_from_id')->nullable()->constrained('page_sections')->onDelete('set null')->comment('Original section if copied');
            $table->json('visibility')->nullable()->comment('Visibility rules: devices, schedule, user_roles');
            $table->text('custom_css')->nullable()->comment('Custom CSS for this section');
            $table->string('custom_class')->nullable()->comment('Custom CSS classes');
            $table->unsignedInteger('cache_ttl')->nullable()->comment('Section-level cache TTL (seconds)');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Creator');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null')->comment('Last updater');
            $table->timestamps();

            // Indexes
            $table->index(['page_id', 'order']);
            $table->index('section_key');
            $table->index('is_active');
            $table->index('copied_from_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
