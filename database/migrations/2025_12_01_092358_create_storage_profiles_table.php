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
        Schema::create('storage_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Profile name: AWS S3, Cloudflare R2, etc.');
            $table->enum('driver', ['local', 's3', 'cloudflare_r2', 'bunnycdn', 'digitalocean_spaces', 'ftp'])->comment('Storage driver');
            $table->json('config')->comment('Driver configuration (encrypted credentials)');
            $table->boolean('is_default')->default(false)->comment('Default storage profile');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->timestamps();

            // Indexes
            $table->index('driver');
            $table->index('is_default');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_profiles');
    }
};
