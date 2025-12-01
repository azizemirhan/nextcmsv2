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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Language code: tr, en, de, etc.');
            $table->string('name', 100)->comment('Display name: Türkçe, English');
            $table->string('native_name', 100)->comment('Native name');
            $table->string('flag', 50)->nullable()->comment('Flag icon/emoji');
            $table->enum('direction', ['ltr', 'rtl'])->default('ltr')->comment('Text direction');
            $table->boolean('is_default')->default(false)->comment('Default language');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->unsignedInteger('order')->default(0)->comment('Display order');
            $table->timestamps();

            // Indexes
            $table->index('code');
            $table->index('is_default');
            $table->index('is_active');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
