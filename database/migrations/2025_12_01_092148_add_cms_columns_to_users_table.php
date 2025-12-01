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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email')->comment('Profile avatar path');
            $table->text('two_factor_secret')->nullable()->after('password')->comment('2FA secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_secret');
            $table->boolean('is_active')->default(true)->after('email_verified_at')->comment('Account status');
            $table->timestamp('last_login_at')->nullable()->comment('Last login timestamp');
            $table->string('last_login_ip', 45)->nullable()->comment('Last login IP address');
            $table->softDeletes()->comment('Soft delete support');

            // Indexes
            $table->index('is_active');
            $table->index('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'two_factor_secret',
                'two_factor_confirmed_at',
                'is_active',
                'last_login_at',
                'last_login_ip',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
