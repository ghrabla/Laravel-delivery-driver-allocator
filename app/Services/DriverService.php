<?php

namespace App\Services;

use App\Repositories\DriverRepository;
use App\Models\Driver;
use App\Models\Restaurant;

class DriverService
{
    public function __construct(
        private DriverRepository $driverRepository,
        private LocationService $locationService,

    ) {}

    public function findById(string $id): Driver|null
    {
        return $this->driverRepository->findById($id);
    }

    public function assignToDriver(string $driverId, Restaurant $restaurant): Driver|null
    {
        $driver = $this->findById($driverId);

        if (!$driver instanceof Driver) {
            return null;
        }

        $this->driverRepository->assignDriverToRestaurant($driver, $restaurant);

        return $driver;
    }
}
