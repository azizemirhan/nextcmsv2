<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_scripts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('script_content');
            $table->enum('location', ['head', 'body_start', 'body_end', 'footer'])->default('body_end');
            $table->enum('load_on', ['all_pages', 'specific_pages', 'exclude_pages'])->default('all_pages');
            $table->json('page_rules')->nullable();
            $table->enum('device', ['all', 'desktop', 'mobile'])->default('all');
            $table->boolean('is_async')->default(false);
            $table->boolean('is_defer')->default(false);
            $table->unsignedInteger('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('location');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_scripts');
    }
};
