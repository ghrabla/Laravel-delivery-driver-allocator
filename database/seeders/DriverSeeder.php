<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use Illuminate\Support\Str;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $baseLat = 34.020882;
        $baseLon = -6.841650;

        for ($i = 0; $i < 50; $i++) {
            Driver::create([
                Driver::ID => (string) Str::uuid(),
                Driver::NAME => 'Driver ' . ($i + 1),
                Driver::LAT => $baseLat + $this->randomOffset(),
                Driver::LON => $baseLon + $this->randomOffset(),
                Driver::IS_AVAILABLE => (bool) random_int(0, 1),
            ]);
        }
    }

    private function randomOffset(): float
    {
        return mt_rand(-2000, 2000) / 100000.0;
    }
}
