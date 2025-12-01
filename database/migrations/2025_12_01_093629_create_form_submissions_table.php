<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->json('data');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('submitter_name')->nullable();
            $table->string('submitter_email')->nullable();
            $table->string('submitter_ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->enum('status', ['unread', 'read', 'replied', 'archived', 'spam'])->default('unread');
            $table->boolean('is_starred')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('form_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
