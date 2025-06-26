<?php

namespace App\Repositories;

use App\Models\Driver;
use App\Models\Restaurant;

class DriverRepository
{
    public function findById(string $id): Driver|null
    {
        return Driver::query()->find($id);
    }
}
