<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('frequency', ['hourly', 'daily', 'weekly', 'monthly'])->default('daily');
            $table->string('cron_expression')->nullable();
            $table->enum('type', ['full', 'database', 'files'])->default('full');
            $table->string('disk', 50)->default('local');
            $table->unsignedInteger('keep_backups')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamp('next_run_at')->nullable();
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_schedules');
    }
};
