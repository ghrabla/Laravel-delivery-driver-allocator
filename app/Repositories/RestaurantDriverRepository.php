<?php

namespace App\Repositories;

use App\Models\RestaurantDriver;

class RestaurantDriverRepository
{
    public function create(array $attributes): RestaurantDriver
    {
        return RestaurantDriver::query()->create($attributes);
    }
}
