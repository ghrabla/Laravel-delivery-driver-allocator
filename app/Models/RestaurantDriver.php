<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantDriver extends Model
{
    use HasUuids;

    protected $table = 'restaurant_driver';

    public const TABLE = 'restaurant_driver';
    public const ID = 'id';
    public const RESTAURANT_ID = 'restaurant_id';
    public const DRIVER_ID = 'driver_id';

    protected $fillable = [
        self::ID,
        self::RESTAURANT_ID,
        self::DRIVER_ID,
    ];

    protected $keyType = 'string';

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
