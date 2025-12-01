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
        Schema::create('menu_locations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Location key: primary, footer, mobile');
            $table->json('name')->comment('Location name (multilingual)');
            $table->json('description')->nullable()->comment('Location description');
            $table->foreignId('menu_id')->nullable()->constrained('menus')->onDelete('set null')->comment('Assigned menu');
            $table->timestamps();

            // Indexes
            $table->index('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_locations');
    }
};
