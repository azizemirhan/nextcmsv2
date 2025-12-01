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
        Schema::create('media_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('media_folders')->onDelete('cascade')->comment('Parent folder (hierarchical)');
            $table->string('name')->comment('Folder name');
            $table->string('slug')->comment('URL-friendly name');
            $table->string('path')->comment('Full path: /images/products');
            $table->string('color', 20)->nullable()->comment('Folder color code');
            $table->boolean('is_system')->default(false)->comment('System folder (protected)');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Creator');
            $table->timestamps();

            // Indexes
            $table->index('parent_id');
            $table->index('path');
            $table->index('is_system');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_folders');
    }
};
