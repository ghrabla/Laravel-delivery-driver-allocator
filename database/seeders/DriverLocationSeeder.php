<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Redis;
use App\Models\Driver;

class DriverLocationSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = Driver::query()->where(Driver::IS_AVAILABLE, true)->get();

        foreach ($drivers as $driver) {
            $lat = fake()->latitude(33.995, 34.015);
            $lon = fake()->longitude(-6.841, -6.821);

            Redis::command('GEOADD', [
                'drivers-location',
                $lon,
                $lat,
                'driver:' . $driver->id,
            ]);

            $this->command->info("Driver {$driver->id} added to Redis at [$lat, $lon]");
        }
    }
}
