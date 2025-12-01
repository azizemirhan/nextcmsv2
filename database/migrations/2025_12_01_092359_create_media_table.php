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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->comment('Unique identifier');
            $table->foreignId('storage_profile_id')->constrained('storage_profiles')->onDelete('restrict')->comment('Storage driver');
            $table->foreignId('folder_id')->nullable()->constrained('media_folders')->onDelete('set null')->comment('Folder');
            
            // File info
            $table->string('filename')->comment('Stored filename');
            $table->string('original_filename')->comment('Original upload filename');
            $table->string('path')->comment('Relative path');
            $table->string('disk', 50)->comment('Filesystem disk name');
            $table->string('extension', 20)->comment('File extension');
            $table->string('mime_type', 100)->comment('MIME type');
            $table->enum('type', ['image', 'video', 'audio', 'document', 'archive', 'other'])->comment('Media type');
            $table->unsignedBigInteger('size_bytes')->comment('File size in bytes');
            
            // Image/Video specific
            $table->unsignedInteger('width')->nullable()->comment('Image/video width');
            $table->unsignedInteger('height')->nullable()->comment('Image/video height');
            $table->unsignedInteger('duration')->nullable()->comment('Video/audio duration (seconds)');
            
            // Security
            $table->string('checksum_sha256')->nullable()->comment('File integrity hash');
            
            // Multilingual metadata
            $table->json('title')->nullable()->comment('Media title');
            $table->json('alt')->nullable()->comment('Alt text for images');
            $table->json('caption')->nullable()->comment('Caption');
            $table->json('description')->nullable()->comment('Description');
            
            // Image processing
            $table->string('dominant_color', 20)->nullable()->comment('Dominant color hex');
            $table->json('focal_point')->nullable()->comment('Smart crop point {x: 50, y: 50}');
            $table->json('exif_data')->nullable()->comment('EXIF metadata');
            
            // Privacy & Analytics
            $table->boolean('is_private')->default(false)->comment('Private file flag');
            $table->unsignedBigInteger('download_count')->default(0)->comment('Download counter');
            
            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Uploader');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null')->comment('Last editor');
            
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('uuid');
            $table->index('folder_id');
            $table->index('type');
            $table->index('mime_type');
            $table->index('created_at');
            $table->index('checksum_sha256');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
