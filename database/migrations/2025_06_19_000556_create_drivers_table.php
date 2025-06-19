<?php

use App\Models\Driver;
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
        Schema::create(Driver::TABLE, function (Blueprint $table) {
            $table->uuid(Driver::ID)->primary();
            $table->string(Driver::NAME);
            $table->decimal(Driver::LAT, 10, 7);
            $table->decimal(Driver::LON, 10, 7);
            $table->boolean(Driver::IS_AVAILABLE)->default(true);
            $table->timestamps();

            $table->index([Driver::LAT, Driver::LON]);
            $table->index(Driver::IS_AVAILABLE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Driver::TABLE);
    }
};
