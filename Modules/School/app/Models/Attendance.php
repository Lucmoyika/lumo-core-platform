<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'school_attendances';

    protected $fillable = [
        'enrollment_id',
        'date',
        'status',
        'reason',
        'notified',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'notified' => 'boolean',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
