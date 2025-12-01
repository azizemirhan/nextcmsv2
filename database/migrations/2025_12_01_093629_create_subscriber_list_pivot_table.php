<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriber_list_pivot', function (Blueprint $table) {
            $table->foreignId('subscriber_id')->constrained('subscribers')->onDelete('cascade');
            $table->foreignId('subscriber_list_id')->constrained('subscriber_lists')->onDelete('cascade');
            $table->timestamp('subscribed_at')->useCurrent();

            $table->primary(['subscriber_id', 'subscriber_list_id'], 'sub_list_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriber_list_pivot');
    }
};
