<?php

use App\Http\Controllers\AssignDriverController;
use Illuminate\Support\Facades\Route;

Route::post('/drivers/assign', AssignDriverController::class);
