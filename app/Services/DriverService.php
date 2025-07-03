<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Restaurant;
use App\Models\RestaurantDriver;
use App\Repositories\DriverRepository;
use App\DTOs\LocationDTO;
use App\Services\RedisService;

class DriverService
{
    public function __construct(
        private DriverRepository $driverRepository,
        private RedisService $redisDriverService,
        private RestaurantDriverService $restaurantDriverService
    ) {}

    public function findById(string $id): ?Driver
    {
        return $this->driverRepository->findById($id);
    }

    public function assignClosestDriver(Restaurant $restaurant, LocationDTO $location): ?Driver
    {
        $key = 'drivers_location';
        $results = $this->redisDriverService->geoRadius(
            $key,
            $location->lon,
            $location->lat,
            5
        );

        if (empty($results)) {
            return null;
        }

        $closestDriverRaw = $results[0];
        $closestDriverId = str_replace('driver:', '', $closestDriverRaw);

        $driver = $this->findById($closestDriverId);
        if (!$driver) {
            return null;
        }

        $this->restaurantDriverService->create([
            RestaurantDriver::RESTAURANT_ID => $restaurant[Restaurant::ID],
            RestaurantDriver::DRIVER_ID => $driver[Driver::ID],
        ]);
        $this->redisDriverService->zRem($key, 'driver:' . $driver[Driver::ID]);

        return $driver;
    }
}
