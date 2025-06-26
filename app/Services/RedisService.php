<?php

namespace App\Services;

use Illuminate\Redis\RedisManager;

class RedisService
{
    public function __construct(
        private RedisManager $redisManager
    ) {}

    public function geoRadius(string $key, float $longitude, float $latitude, float $radiusKm = 5): array
    {
        return $this->redisManager->geoRadius(
            $key,
            $longitude,
            $latitude,
            $radiusKm,
            'km',
            [
                'WITHDIST',
                'COUNT' => 1,
                'ASC',
            ]
        );
    }

    public function zRem(string $key, string $member): int
    {
        return $this->redisManager->zRem($key, $member);
    }

    public function geoAdd(string $key, float $longitude, float $latitude, string $member): int
    {
        return $this->redisManager->geoadd($key, $longitude, $latitude, $member);
    }
}
