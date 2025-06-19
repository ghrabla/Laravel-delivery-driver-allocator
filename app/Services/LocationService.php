<?php

namespace App\Services;

use App\ValueObjects\Location;

class LocationService
{
    public function create(float $lat, float $lon): Location
    {
        return new Location($lat, $lon);
    }
}
