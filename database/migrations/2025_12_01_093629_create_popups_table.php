<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->unique();
            $table->json('title')->nullable();
            $table->json('content');
            $table->string('type', 50)->default('modal');
            $table->string('size', 20)->default('medium');
            $table->string('position', 50)->nullable();
            $table->enum('trigger', ['time_delay', 'scroll_percent', 'exit_intent', 'click'])->default('time_delay');
            $table->unsignedInteger('trigger_value')->nullable();
            $table->json('display_rules')->nullable();
            $table->json('frequency_rules')->nullable();
            $table->json('design_settings')->nullable();
            $table->boolean('show_close_button')->default(true);
            $table->unsignedInteger('close_delay')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('conversion_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('popups');
    }
};
