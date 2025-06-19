<?php

namespace App\Repositories;

use App\Models\Driver;

class DriverRepository
{
    public function findAvailableDriversNear(object $pickupLocation, float $radiusKm = 5): Driver|null
    {
        return Driver::query()
            ->selectRaw("
                *,
                (6371 * acos(
                    cos(radians(?)) *
                    cos(radians(" . Driver::LAT . ")) *
                    cos(radians(" . Driver::LON . ") - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(" . Driver::LAT . "))
                )) AS distance
            ", [
                $pickupLocation->lat(),
                $pickupLocation->lon(),
                $pickupLocation->lat()
            ])
            ->where(Driver::IS_AVAILABLE, true)
            ->having('distance', '<=', $radiusKm)
            ->orderBy('distance', 'asc')
            ->first();
    }
}
