<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recaptcha_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('version', ['v2', 'v3'])->default('v3');
            $table->string('site_key');
            $table->string('secret_key');
            $table->float('v3_score_threshold', 2, 1)->default(0.5);
            $table->enum('v2_theme', ['light', 'dark'])->default('light');
            $table->enum('v2_size', ['normal', 'compact'])->default('normal');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recaptcha_settings');
    }
};
