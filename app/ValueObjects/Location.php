<?php

namespace App\ValueObjects;

class Location
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lon
    ) {}

    public function lat(): float
    {
        return $this->lat;
    }

    public function lon(): float
    {
        return $this->lon;
    }
}
