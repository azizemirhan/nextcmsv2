<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('status', ['subscribed', 'unsubscribed', 'pending', 'bounced'])->default('pending');
            $table->string('language', 10)->default('tr');
            $table->string('source', 50)->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->string('confirmation_token')->nullable();
            $table->string('unsubscribe_token')->unique();
            $table->timestamps();

            $table->index('email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
