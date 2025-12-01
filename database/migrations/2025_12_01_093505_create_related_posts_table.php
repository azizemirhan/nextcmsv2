<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('related_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('related_post_id')->constrained('posts')->onDelete('cascade');
            $table->enum('relation_type', ['auto', 'manual'])->default('manual');
            $table->unsignedTinyInteger('score')->nullable()->comment('Relevance score 0-100');
            $table->unsignedInteger('order')->default(0);

            $table->index('post_id');
            $table->unique(['post_id', 'related_post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('related_posts');
    }
};
