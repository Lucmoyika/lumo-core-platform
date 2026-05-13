<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $table = 'school_vehicles';

    protected $fillable = [
        'plate_number',
        'brand',
        'model',
        'capacity',
        'driver_name',
        'driver_phone',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
        ];
    }

    public function transportRoutes(): HasMany
    {
        return $this->hasMany(TransportRoute::class, 'vehicle_id');
    }
}
