<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin role
        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@cms.local'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@cms.local',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // Assign role
        $admin->assignRole($role);

        $this->command->info("✅ Admin user created: admin@cms.local / password");
    }
}
