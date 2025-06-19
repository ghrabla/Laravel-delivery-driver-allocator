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

    public function assignDriver(Driver $driver, Restaurant $restaurant): Driver
    {
        $this->driverRepository->assignDriverToRestaurant($driver, $restaurant);
        return $driver;
    }
}
