<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_meta_tags', function (Blueprint $table) {
            $table->id();
            $table->enum('provider', ['google', 'bing', 'yandex', 'pinterest', 'facebook', 'custom'])->unique();
            $table->string('tag_name')->nullable();
            $table->string('tag_content');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_meta_tags');
    }
};
