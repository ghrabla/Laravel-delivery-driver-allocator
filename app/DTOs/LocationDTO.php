<?php

namespace App\DTOs;

class LocationDTO
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lon
    ) {}
}
