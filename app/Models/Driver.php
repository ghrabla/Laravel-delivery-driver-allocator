<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    public const TABLE = 'drivers';
    public const ID = 'id';
    public const NAME = 'name';
    public const IS_AVAILABLE = 'is_available';

    protected $casts = [
        Driver::ID => 'string',
    ];

    protected $fillable = [
        self::NAME,
        self::IS_AVAILABLE,
    ];

    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_driver');
    }
}
