<?php

namespace App\Services;

use App\Models\RestaurantDriver;
use App\Repositories\RestaurantDriverRepository;

class RestaurantDriverService
{
    public function __construct(
        private RestaurantDriverRepository $restaurantDriverRepository
    ) {}

    public function create(array $attributes): RestaurantDriver
    {
        return $this->restaurantDriverRepository->create($attributes);
    }
}
