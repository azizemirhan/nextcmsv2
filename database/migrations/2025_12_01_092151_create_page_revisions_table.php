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
        Schema::create('page_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade')->comment('Parent page');
            $table->unsignedInteger('revision_number')->comment('Revision number (incremental)');
            $table->json('title')->comment('Page title at this revision');
            $table->json('sections_snapshot')->comment('Complete sections data snapshot');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->comment('Who created this revision');
            $table->timestamp('created_at')->comment('Revision timestamp');

            // Indexes
            $table->index('page_id');
            $table->index(['page_id', 'revision_number']);
            $table->unique(['page_id', 'revision_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_revisions');
    }
};
