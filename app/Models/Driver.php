<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    public const TABLE = 'drivers';
    public const ID = 'id';
    public const NAME = 'name';
    public const LAT = 'latitude';
    public const LON = 'longitude';
    public const IS_AVAILABLE = 'is_available';

    protected $casts = [
        Driver::ID => 'string',
    ];

    protected $fillable = [
        self::NAME,
        self::LAT,
        self::LON,
        self::IS_AVAILABLE,
    ];
}
