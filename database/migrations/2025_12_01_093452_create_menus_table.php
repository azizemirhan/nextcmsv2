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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->json('name')->comment('Menu name (multilingual)');
            $table->string('slug')->unique()->comment('Menu identifier');
            $table->string('location', 50)->nullable()->comment('Location: header, footer, sidebar');
            $table->string('description')->nullable()->comment('Menu description');
            $table->unsignedTinyInteger('max_depth')->default(3)->comment('Maximum nesting depth');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->timestamps();

            // Indexes
            $table->index('slug');
            $table->index('location');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
