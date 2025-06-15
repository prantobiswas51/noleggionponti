<?php

namespace Database\Seeders;

use App\Models\Esp32Device;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Esp32Device::create([
            'name' => 'Device 1',
            'identifier' => 'ABC123',
        ]);

        Esp32Device::create([
            'name' => 'Device 2',
            'identifier' => 'JKL223',
        ]);

        Esp32Device::create([
            'name' => 'Device 3',
            'identifier' => 'XYZ333',
        ]);
    }
}
