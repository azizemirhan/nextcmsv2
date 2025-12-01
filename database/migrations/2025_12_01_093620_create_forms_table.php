<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->json('fields_schema');
            $table->json('submit_button_text');
            $table->json('success_message');
            $table->string('redirect_url')->nullable();
            $table->boolean('enable_recaptcha')->default(false);
            $table->string('recaptcha_version', 5)->default('v3');
            $table->boolean('send_email')->default(true);
            $table->string('email_to')->nullable();
            $table->string('email_subject')->nullable();
            $table->json('email_template')->nullable();
            $table->boolean('save_submissions')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('submission_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
