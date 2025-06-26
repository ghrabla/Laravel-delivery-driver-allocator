<?php

use App\Models\Driver;
use App\Models\Restaurant;
use App\Models\RestaurantDriver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(RestaurantDriver::TABLE, function (Blueprint $table) {
            $table->uuid(RestaurantDriver::ID)->primary();
            $table->uuid(RestaurantDriver::RESTAURANT_ID);
            $table->uuid(RestaurantDriver::DRIVER_ID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(RestaurantDriver::TABLE);
    }
};
