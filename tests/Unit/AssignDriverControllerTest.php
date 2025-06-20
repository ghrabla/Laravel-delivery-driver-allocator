<?php

namespace Tests\Unit;

use App\Http\Controllers\AssignDriverController;
use App\Http\Requests\AssignDriverRequest;
use App\Models\Driver;
use App\Models\Restaurant;
use App\Services\DispatcherService;
use App\Services\DriverService;
use App\Services\LocationService;
use App\Services\RestaurantService;
use App\ValueObjects\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AssignDriverControllerTest extends TestCase
{
    private $restaurantService;
    private $dispatcherService;
    private $driverService;
    private $locationService;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->restaurantService = Mockery::mock(RestaurantService::class);
        $this->dispatcherService = Mockery::mock(DispatcherService::class);
        $this->driverService = Mockery::mock(DriverService::class);
        $this->locationService = Mockery::mock(LocationService::class);

        $this->controller = new AssignDriverController(
            $this->driverService,
            $this->restaurantService,
            $this->dispatcherService,
            $this->locationService
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function it_assigns_driver_successfully(): void
    {
        $restaurant = new Restaurant([
            Restaurant::ID => Str::uuid(),
            Restaurant::NAME => 'Test Restaurant'
        ]);

        $driver = new Driver([
            Driver::ID => Str::uuid(),
            Driver::NAME => 'Test Driver'
        ]);

        $request = $this->makeAssignDriverRequestMock();
        $location = new Location(33.6, -7.6);

        $this->restaurantService->shouldReceive('findById')
            ->with(1)
            ->andReturn($restaurant);

        $this->locationService->shouldReceive('create')
            ->with(33.6, -7.6)
            ->andReturn($location);

        $this->dispatcherService->shouldReceive('findClosestDriver')
            ->with($location)
            ->andReturn($driver);

        $this->driverService->shouldReceive('assignDriver')
            ->with($driver, $restaurant)
            ->once();

        $response = $this->controller->__invoke($request);

        $this->assertJsonResponse($response, 200, 'Driver assigned successfully');
    }

    #[Test]
    public function it_returns_404_if_no_driver_found(): void
    {
        $restaurant = new Restaurant([
            Restaurant::ID => Str::uuid(),
            Restaurant::NAME => 'Test Restaurant'
        ]);

        $request = $this->makeAssignDriverRequestMock();
        $location = new Location(33.6, -7.6);

        $this->restaurantService->shouldReceive('findById')
            ->with(1)
            ->andReturn($restaurant);

        $this->locationService->shouldReceive('create')
            ->with(33.6, -7.6)
            ->andReturn($location);

        $this->dispatcherService->shouldReceive('findClosestDriver')
            ->with($location)
            ->andReturn(null);

        $response = $this->controller->__invoke($request);

        $this->assertJsonResponse($response, 404, 'No available drivers');
    }

    #[Test]
    public function it_returns_500_if_exception_occurs(): void
    {
        $request = $this->makeAssignDriverRequestMock();

        $this->restaurantService->shouldReceive('findById')
            ->with(1)
            ->andThrow(new \Exception('Test exception'));

        $response = $this->controller->__invoke($request);

        $this->assertJsonResponse($response, 500, 'An error occurred while assigning a driver.');
    }

    /**
     * Helper to create a mocked AssignDriverRequest
     */
    private function makeAssignDriverRequestMock(): AssignDriverRequest
    {
        $request = Mockery::mock(AssignDriverRequest::class);
        $request->shouldReceive('restaurantId')->andReturn(1);
        $request->shouldReceive('latitude')->andReturn(33.6);
        $request->shouldReceive('longitude')->andReturn(-7.6);

        return $request;
    }

    /**
     * Helper to assert JsonResponse status and message
     */
    private function assertJsonResponse(JsonResponse $response, int $status, string $message): void
    {
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($status, $response->status());
        $this->assertEquals($message, $response->getData()->message);
    }
}
