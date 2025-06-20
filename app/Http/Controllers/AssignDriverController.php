<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Services\DriverService;
use App\Http\Requests\AssignDriverRequest;
use App\Models\Restaurant;
use App\Services\DispatcherService;
use App\Services\LocationService;
use App\Services\RestaurantService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AssignDriverController extends Controller
{
    public function __construct(
        private DriverService $driverService,
        private RestaurantService $restaurantService,
        private DispatcherService $dispatcherService,
        private LocationService $locationService
    ) {}

    public function __invoke(AssignDriverRequest $request): JsonResponse
    {
        try {
            $restaurant = $this->restaurantService->findById($request->restaurantId());
            $location = $this->locationService->create($request->latitude(), $request->longitude());

            $driver = $this->dispatcherService->assignToDriver($restaurant, $location);
            if (!$driver instanceof Driver) {
                return response()->json([
                    'message' => 'No available drivers',
                ], 404);
            }

            Log::info('Driver assigned successfully', [
                Driver::ID => $driver[Driver::ID],
                Restaurant::ID => $restaurant[Restaurant::ID],
            ]);

            return response()->json([
                'message' => 'Driver assigned successfully',
                'data' => $driver
            ], 200);
        } catch (Exception $e) {
            Log::error('Error assigning driver', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'An error occurred while assigning a driver.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
