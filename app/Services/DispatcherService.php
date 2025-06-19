<?php

namespace App\Services;

use App\Models\Driver;
use Illuminate\Support\Facades\Redis;

class DispatcherService
{
    public function __construct(
        private LocationService $locationService,
        private DriverService $driverService,

    ) {}


    public function findClosestDriver(float $lat, float $lon): Driver|null
    {
        $result = Redis::command('GEORADIUS', [
            'drivers-location',
            $lon,
            $lat,
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
