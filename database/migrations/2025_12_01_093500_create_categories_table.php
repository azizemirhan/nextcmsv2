<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade')->comment('Parent category');
            $table->string('slug')->unique()->comment('URL slug');
            $table->json('name')->comment('Category name');
            $table->json('description')->nullable()->comment('Description');
            $table->unsignedBigInteger('image_id')->nullable()->comment('Category image');
            $table->string('color', 20)->nullable()->comment('Color code');
            $table->string('icon')->nullable()->comment('Icon class');
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('parent_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
