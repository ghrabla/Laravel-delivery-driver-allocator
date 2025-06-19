<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Services\DriverService;
use App\Http\Requests\AssignDriverRequest;
use App\Models\Restaurant;
use App\Services\DispatcherService;
use App\Services\RestaurantService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AssignDriverController extends Controller
{
    public function __construct(
        private DriverService $driverService,
        private RestaurantService $restaurantService,
        private DispatcherService $dispatcherService
    ) {}

    public function __invoke(AssignDriverRequest $request): JsonResponse
    {
        try {
            $restaurant = $this->restaurantService->findById(
                $request->restaurantId()
            );

            $driver = $this->dispatcherService->findClosestDriver(
                $request->latitude(),
                $request->longitude()
            );

            if (!$driver instanceof Driver) {
                return response()->json([
                    'message' => 'No available drivers',
                ], 404);
            }

            $this->driverService->assignDriver(
                $driver,
                $restaurant
            );

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
