<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    protected function successResponse(
        string $message,
        mixed $data = null,
        int $status = Response::HTTP_OK
    ): JsonResponse {
        $response = [
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    protected function failedResponse(
        string $message,
        int $status = Response::HTTP_BAD_REQUEST,
        mixed $error = null
    ): JsonResponse {
        $response = [
            'message' => $message,
        ];

        if ($error !== null) {
            $response['error'] = $error;
        }

        return response()->json($response, $status);
    }
}
