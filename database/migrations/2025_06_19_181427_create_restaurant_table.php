<?php

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
        Schema::create(Restaurant::TABLE, function (Blueprint $table) {
            $table->uuid(Restaurant::ID)->primary();
            $table->string(Restaurant::NAME);
            $table->decimal(Restaurant::LAT, 10, 7);
            $table->decimal(Restaurant::LON, 10, 7);
            $table->timestamps();

            $table->index([Restaurant::LAT, Restaurant::LON]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Restaurant::TABLE);
    }
};
