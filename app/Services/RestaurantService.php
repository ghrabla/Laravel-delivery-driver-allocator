<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;

class RestaurantService
{
    public function __construct(private RestaurantRepository $restaurantRepository) {}

    public function findById(string $id): ?Restaurant
    {
        return $this->restaurantRepository->findById($id);
    }
}
