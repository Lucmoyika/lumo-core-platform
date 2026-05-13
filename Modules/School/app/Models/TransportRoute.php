<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportRoute extends Model
{
    protected $table = 'school_transport_routes';

    protected $fillable = [
        'name',
        'vehicle_id',
        'departure_time',
        'arrival_time',
        'description',
        'monthly_fee',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'monthly_fee' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function studentTransports(): HasMany
    {
        return $this->hasMany(StudentTransport::class, 'route_id');
    }
}
