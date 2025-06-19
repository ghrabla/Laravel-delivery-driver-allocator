<?php

use App\Http\Controllers\AssignDriverController;
use Illuminate\Support\Facades\Route;

Route::post('/drivers/assign', AssignDriverController::class);
Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});
