<?php

namespace Tests\Unit;

use App\Services\DispatcherService;
use App\Services\LocationService;
use App\Services\DriverService;
use App\Models\Restaurant;
use App\Models\Driver;
use App\ValueObjects\Location;
use Illuminate\Support\Facades\Redis;
use Mockery;
use Tests\TestCase;

class DispatcherServiceTest extends TestCase
{
    protected $locationService;
    protected $driverService;
    protected $dispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->locationService = Mockery::mock(LocationService::class);
        $this->driverService = Mockery::mock(DriverService::class);

        $this->dispatcher = new DispatcherService(
            $this->locationService,
            $this->driverService
        );
    }

    public function test_assign_to_driver_returns_null_if_no_driver_found(): void
    {
        Redis::shouldReceive('command')
            ->once()
            ->with('GEORADIUS', Mockery::any())
            ->andReturn([]);

        $restaurant = Mockery::mock(Restaurant::class);
        $location = new Location(34.0, -6.0);

        $result = $this->dispatcher->assignToDriver($restaurant, $location);

        $this->assertNull($result);
    }

    public function test_assign_to_driver_assigns_and_removes_driver(): void
    {
        Redis::shouldReceive('command')
            ->once()
            ->with('GEORADIUS', Mockery::any())
            ->andReturn([['driver:abc123', '0.1']]);

        Redis::shouldReceive('command')
            ->once()
            ->with('ZREM', ['drivers-location', 'driver:abc123']);

        $driver = new Driver([Driver::ID => 'abc123']);
        $restaurant = Mockery::mock(Restaurant::class);
        $location = new Location(34.0, -6.0);

        $this->driverService
            ->shouldReceive('findById')
            ->once()
            ->with('abc123')
            ->andReturn($driver);

        $this->driverService
            ->shouldReceive('assignDriver')
            ->once()
            ->with($driver, $restaurant);

        $result = $this->dispatcher->assignToDriver($restaurant, $location);

        $this->assertSame($driver, $result);
    }

    public function test_find_closest_driver_returns_null_if_none_found(): void
    {
        Redis::shouldReceive('command')
            ->once()
            ->with('GEORADIUS', Mockery::any())
            ->andReturn([]);

        $location = new Location(34.0, -6.0);

        $method = new \ReflectionMethod(DispatcherService::class, 'findClosestDriver');
        $method->setAccessible(true);

        $result = $method->invoke($this->dispatcher, $location);

        $this->assertNull($result);
    }

    public function test_remove_driver_calls_redis_zrem(): void
    {
        Redis::shouldReceive('command')
            ->once()
            ->with('ZREM', ['drivers-location', 'driver:abc123']);

        $method = new \ReflectionMethod(DispatcherService::class, 'removeDriver');
        $method->setAccessible(true);

        $method->invoke($this->dispatcher, 'abc123');

        $this->assertTrue(true);
    }
}
