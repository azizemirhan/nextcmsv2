<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('banner_enabled')->default(true)->after('banner_subtitle');
            $table->string('banner_background_image')->nullable()->after('banner_enabled');
            $table->string('banner_background_color')->nullable()->after('banner_background_image');
            $table->string('banner_overlay_opacity')->default('0.3')->after('banner_background_color');
            $table->string('banner_text_color')->default('white')->after('banner_overlay_opacity');
            $table->enum('banner_height', ['small', 'medium', 'large', 'full'])->default('medium')->after('banner_text_color');
            $table->enum('banner_text_align', ['left', 'center', 'right'])->default('center')->after('banner_height');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'banner_enabled',
                'banner_background_image',
                'banner_background_color',
                'banner_overlay_opacity',
                'banner_text_color',
                'banner_height',
                'banner_text_align',
            ]);
        });
    }
};
