<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Services\DriverService;
use App\Http\Requests\AssignDriverRequest;
use App\Services\DispatcherService;
use App\Services\RestaurantService;
use Exception;
use Illuminate\Http\JsonResponse;

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


            return response()->json([
                'message' => 'Driver assigned successfully',
                'data' => $driver
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while assigning a driver.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
