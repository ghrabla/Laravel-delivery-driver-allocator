<?php

namespace App\Repositories;

use App\Models\Driver;

class DriverRepository
{
    public function findById(string $id): Driver|null
    {
        return Driver::query()->with('restaurants')->find($id);
    }
}
