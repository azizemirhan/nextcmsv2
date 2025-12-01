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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade')->comment('Parent menu');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade')->comment('Parent item (nested)');
            $table->json('title')->comment('Item title (multilingual)');
            $table->enum('type', ['page', 'post', 'category', 'url', 'route', 'placeholder'])->comment('Link type');
            $table->nullableMorphs('linkable'); // linkable_type, linkable_id
            $table->string('url')->nullable()->comment('Custom URL');
            $table->string('route_name')->nullable()->comment('Laravel route name');
            $table->json('route_params')->nullable()->comment('Route parameters');
            $table->enum('target', ['_self', '_blank'])->default('_self')->comment('Link target');
            $table->string('rel')->nullable()->comment('Link rel attribute: nofollow, sponsored');
            $table->string('icon')->nullable()->comment('Icon class');
            $table->unsignedBigInteger('image_id')->nullable()->comment('Menu item image');
            $table->string('css_class')->nullable()->comment('Custom CSS classes');
            $table->boolean('is_mega_menu')->default(false)->comment('Mega menu flag');
            $table->unsignedTinyInteger('mega_columns')->nullable()->comment('Mega menu columns');
            $table->json('mega_content')->nullable()->comment('Mega menu content');
            $table->string('highlight_type')->nullable()->comment('Badge: new, hot, sale');
            $table->json('highlight_text')->nullable()->comment('Badge text (multilingual)');
            $table->unsignedInteger('order')->default(0)->comment('Display order');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->timestamps();

            // Indexes
            $table->index(['menu_id', 'parent_id', 'order']);
            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
