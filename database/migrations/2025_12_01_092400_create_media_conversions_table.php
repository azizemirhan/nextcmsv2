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
        Schema::create('media_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade')->comment('Parent media');
            $table->string('conversion_name', 50)->comment('Conversion: thumb, medium, large, webp');
            $table->string('path')->comment('Converted file path');
            $table->string('disk', 50)->comment('Storage disk');
            $table->string('filename')->comment('Converted filename');
            $table->unsignedInteger('width')->nullable()->comment('Width');
            $table->unsignedInteger('height')->nullable()->comment('Height');
            $table->unsignedBigInteger('size_bytes')->comment('File size');
            $table->string('format', 20)->comment('Format: webp, jpg, png');
            $table->unsignedTinyInteger('quality')->nullable()->comment('Quality: 1-100');
            $table->timestamps();

            // Indexes
            $table->index(['media_id', 'conversion_name']);
            $table->unique(['media_id', 'conversion_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_conversions');
    }
};
