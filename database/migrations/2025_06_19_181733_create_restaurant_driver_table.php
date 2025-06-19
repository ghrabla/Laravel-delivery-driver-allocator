<?php

use App\Models\Driver;
use App\Models\Restaurant;
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
    Schema::create('restaurant_driver', function (Blueprint $table) {
        $table->uuid('restaurant_id');
        $table->uuid('driver_id');
        $table->timestamps();

        $table->primary(['restaurant_id', 'driver_id']);

        $table->foreign('restaurant_id')->references('id')->on(Restaurant::TABLE)->onDelete('cascade');
        $table->foreign('driver_id')->references('id')->on(Driver::TABLE)->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_driver');
    }
};
