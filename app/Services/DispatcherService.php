<?php

namespace App\Services;

use App\Models\Driver;
use App\ValueObjects\Location;
use Illuminate\Support\Facades\Redis;

class DispatcherService
{
    public function __construct(
        private LocationService $locationService,
        private DriverService $driverService,
    ) {}

    public function findClosestDriver(Location $location): Driver|null
    {
        $result = Redis::command('GEORADIUS', [
            'drivers-location',
            $location->lon(),
            $location->lat(),
            5,
            'km',
            'WITHDIST',
            'COUNT',
            1,
            'ASC',
        ]);

        if (empty($result)) {
            return null;
        }

        $driverId = str_replace('driver:', '', $result[0][0]);

        return $this->driverService->findById($driverId);
    }
}
