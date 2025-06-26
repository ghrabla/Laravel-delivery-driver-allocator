<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Services\DriverService;
use App\Http\Requests\AssignDriverRequest;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use App\DTOs\LocationDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AssignDriverController extends Controller
{
    public function __construct(
        private DriverService $driverService,
        private RestaurantService $restaurantService,
    ) {}

    public function __invoke(AssignDriverRequest $request): JsonResponse
    {
        try {
            $restaurant = $this->restaurantService->findById($request->restaurantId());
            if (!$restaurant instanceof Restaurant) {
                return $this->failedResponse('Restaurant not found', 404);
            }

            $location = new LocationDTO($request->latitude(), $request->longitude());
            $driver = $this->driverService->assignClosestDriver($restaurant, $location);
            if (!$driver instanceof Driver) {
                return $this->failedResponse('No available drivers', 404);
            }

            Log::info('Driver assigned successfully', [
                Driver::ID => $driver[Driver::ID],
                Restaurant::ID => $restaurant[Restaurant::ID],
            ]);

            return $this->successResponse('Driver assigned successfully', $driver);
        } catch (Exception $e) {
            Log::error('Error assigning driver', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->failedResponse('An error occurred while assigning a driver.', 500, $e->getMessage());
        }
    }
}
