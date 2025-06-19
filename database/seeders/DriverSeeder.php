<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use Illuminate\Support\Str;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            Driver::create([
                Driver::ID => (string) Str::uuid(),
                Driver::NAME => 'Driver ' . ($i + 1),
                Driver::IS_AVAILABLE => (bool) random_int(0, 1),
            ]);
        }
    }
}
