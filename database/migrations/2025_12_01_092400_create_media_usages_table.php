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
        Schema::create('media_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade')->comment('Media file');
            $table->morphs('usable'); // usable_type, usable_id
            $table->string('field_name')->nullable()->comment('Field: featured_image, gallery, etc.');
            $table->timestamps();

            // Indexes
            $table->index('media_id');
            $table->index(['media_id', 'usable_type', 'usable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_usages');
    }
};
