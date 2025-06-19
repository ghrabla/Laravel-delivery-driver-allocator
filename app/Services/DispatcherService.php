<?php

namespace App\Services;

use App\Repositories\DriverRepository;
use App\Models\Driver;

class DispatcherService
{
    public function __construct(
        private DriverRepository $driverRepository,
        private LocationService $locationService
    ) {}

    public function assignToDriver(float $lat, float $lon): Driver|null
    {
        $pickupLocation = $this->locationService->create($lat, $lon);
        $driver = $this->driverRepository->findAvailableDriversNear($pickupLocation);

        if (!$driver) {
            return null;
        }

        return $driver;
    }
}
