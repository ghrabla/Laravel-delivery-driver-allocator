<?php

namespace App\Repositories;

use App\Models\Driver;
use App\Models\Restaurant;

class DriverRepository
{
    public function findById(string $id): Driver|null
    {
        return Driver::query()->find($id);
    }

    public function assignDriverToRestaurant(Driver $driver, Restaurant $restaurant)
    {
        return  $driver->restaurants()->sync($restaurant);
    }
}
