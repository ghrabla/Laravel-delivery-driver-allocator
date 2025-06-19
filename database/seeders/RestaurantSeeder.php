<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                Restaurant::NAME => 'Pizza Palace',
                Restaurant::LAT  => 34.0219,
                Restaurant::LON  => -6.8416,
            ],
            [
                Restaurant::NAME => 'Sushi Corner',
                Restaurant::LAT  => 34.0250,
                Restaurant::LON  => -6.8500,
            ],
            [
                Restaurant::NAME => 'Burger Spot',
                Restaurant::LAT  => 34.0190,
                Restaurant::LON  => -6.8300,
            ],
        ];

        foreach ($restaurants as $data) {
            Restaurant::create([
                Restaurant::ID   => Str::uuid(),
                Restaurant::NAME => $data[Restaurant::NAME],
                Restaurant::LAT  => $data[Restaurant::LAT],
                Restaurant::LON  => $data[Restaurant::LON],
            ]);
        }
    }
}
