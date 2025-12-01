<?php

namespace Database\Seeders;

use App\Models\StorageProfile;
use Illuminate\Database\Seeder;

class StorageProfileSeeder extends Seeder
{
    public function run(): void
    {
        StorageProfile::updateOrCreate(
            ['name' => 'Local Storage'],
            [
                'name' => 'Local Storage',
                'driver' => 'local',
                'config' => [
                    'disk' => 'public',
                    'root' => storage_path('app/public'),
                ],
                'is_default' => true,
                'is_active' => true,
            ]
        );
    }
}
