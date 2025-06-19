<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Services\DispatcherService;
use App\Http\Requests\AssignDriverRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class AssignDriverController extends Controller
{
    public function __construct(private DispatcherService $dispatcherService) {}

    public function __invoke(AssignDriverRequest $request): JsonResponse
    {
        try {
            $driver = $this->dispatcherService->assignToDriver(
                $request->latitude(),
                $request->longitude()
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
