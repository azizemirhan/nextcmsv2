<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('settings_groups')->onDelete('cascade');
            $table->string('key')->unique();
            $table->json('label');
            $table->json('help_text')->nullable();
            $table->enum('type', ['text', 'textarea', 'number', 'boolean', 'select', 'multiselect', 'image', 'file', 'color', 'date', 'time', 'datetime', 'json'])->default('text');
            $table->json('value')->nullable();
            $table->json('default_value')->nullable();
            $table->json('options')->nullable();
            $table->json('validation_rules')->nullable();
            $table->boolean('is_translatable')->default(false);
            $table->boolean('is_encrypted')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index('group_id');
            $table->index('key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
