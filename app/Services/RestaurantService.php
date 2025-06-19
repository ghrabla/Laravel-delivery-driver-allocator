<?php

namespace App\Services;

use App\Repositories\RestaurantRepository;
use App\Models\Restaurant;

class RestaurantService
{
    public function __construct(private RestaurantRepository $restaurantRepository) {}

    public function findById(string $id): Restaurant|null
    {
        return $this->restaurantRepository->findById($id);
    }
}
