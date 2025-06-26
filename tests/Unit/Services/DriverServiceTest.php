<?php

namespace Tests\Unit;

use App\Models\Driver;
use App\Models\Restaurant;
use App\Models\RestaurantDriver;
use App\Repositories\DriverRepository;
use App\Services\DriverService;
use App\Services\RedisService;
use App\Services\RestaurantDriverService;
use App\DTOs\LocationDTO;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class DriverServiceTest extends TestCase
{
    protected $driverRepository;
    protected $redisService;
    protected $restaurantDriverService;
    protected DriverService $driverService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->driverRepository = Mockery::mock(DriverRepository::class);
        $this->redisService = Mockery::mock(RedisService::class);
        $this->restaurantDriverService = Mockery::mock(RestaurantDriverService::class);

        $this->driverService = new DriverService(
            $this->driverRepository,
            $this->redisService,
            $this->restaurantDriverService
        );
    }

    public function test_assign_closest_driver_returns_null_when_no_results(): void
    {
        $restaurant = Mockery::mock(Restaurant::class);
        $location = new LocationDTO(34.0, -6.0);

        $this->redisService
            ->shouldReceive('geoRadius')
            ->once()
            ->with('drivers_location', $location->lon, $location->lat, 5)
            ->andReturn([]);

        $result = $this->driverService->assignClosestDriver($restaurant, $location);

        $this->assertNull($result);
    }

    public function test_assign_closest_driver_returns_null_if_driver_not_found(): void
    {
        $restaurant = Mockery::mock(Restaurant::class);
        $restaurant->shouldReceive('offsetGet')->with(Restaurant::ID)->andReturn('res123');
        $location = new LocationDTO(34.0, -6.0);

        $this->redisService
            ->shouldReceive('geoRadius')
            ->once()
            ->andReturn(['driver:abc123']);

        $this->driverRepository
            ->shouldReceive('findById')
            ->once()
            ->with('abc123')
            ->andReturn(null);

        $result = $this->driverService->assignClosestDriver($restaurant, $location);

        $this->assertNull($result);
    }

    public function test_assign_closest_driver_assigns_driver_and_removes_from_redis(): void
    {
        $restaurantId = 'res123';
        $driverId = 'abc123';

        $restaurant = Mockery::mock(Restaurant::class);
        $restaurant->shouldReceive('offsetGet')->with(Restaurant::ID)->andReturn($restaurantId);

        $driver = Mockery::mock(Driver::class);
        $driver->shouldReceive('offsetGet')->with(Driver::ID)->andReturn($driverId);

        $location = new LocationDTO(34.0, -6.0);

        $this->redisService
            ->shouldReceive('geoRadius')
            ->once()
            ->with('drivers_location', $location->lon, $location->lat, 5)
            ->andReturn(['driver:' . $driverId]);

        $this->driverRepository
            ->shouldReceive('findById')
            ->once()
            ->with($driverId)
            ->andReturn($driver);

        $this->restaurantDriverService
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($data) use ($restaurantId, $driverId) {
                return $data[RestaurantDriver::RESTAURANT_ID] === $restaurantId &&
                       $data[RestaurantDriver::DRIVER_ID] === $driverId &&
                       Str::isUuid($data[RestaurantDriver::ID]);
            }));

        $this->redisService
            ->shouldReceive('zRem')
            ->once()
            ->with('drivers_location', 'driver:' . $driverId);

        $result = $this->driverService->assignClosestDriver($restaurant, $location);

        $this->assertSame($driver, $result);
    }
}
