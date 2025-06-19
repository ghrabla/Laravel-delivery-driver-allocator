<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Services\DriverService;
use App\Http\Requests\AssignDriverRequest;
use App\Services\RestaurantService;
use Exception;
use Illuminate\Http\JsonResponse;

class AssignDriverController extends Controller
{
    public function __construct(
        private DriverService $driverService,
        private RestaurantService $restaurantService
    ) {}

    public function __invoke(AssignDriverRequest $request): JsonResponse
    {
        try {
            $restaurant = $this->restaurantService->findById(
                $request->restaurantId()
            );

            $driver = $this->driverService->assignToDriver(
                "0177dadb-f926-4405-9e57-2dd0356a9db1",
                $restaurant
            );

            if (!$driver instanceof Driver) {
                return response()->json([
                    'message' => 'No available drivers',
                ], 404);
            }

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
