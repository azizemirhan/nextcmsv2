<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->json('banner_title')->nullable()->after('excerpt');
            $table->json('banner_subtitle')->nullable()->after('banner_title');
            $table->string('banner_image_id')->nullable()->after('banner_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['banner_title', 'banner_subtitle', 'banner_image_id']);
        });
    }
};
