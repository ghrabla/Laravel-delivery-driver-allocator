<?php

namespace App\Repositories;

use App\Models\Restaurant;    

class RestaurantRepository
{
    public function findById(string $id): Restaurant|null
    {
        return Restaurant::query()->find($id);
    }

}
