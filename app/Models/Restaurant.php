<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurants';

    public const TABLE = 'restaurants';
    public const ID = 'id';
    public const NAME = 'name';
    public const LAT = 'latitude';
    public const LON = 'longitude';

    protected $casts = [
        Restaurant::ID => 'string',
    ];

    protected $fillable = [
        self::NAME,
        self::LAT,
        self::LON,
    ];

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'restaurant_driver');
    }
}
