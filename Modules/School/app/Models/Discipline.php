<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discipline extends Model
{
    protected $table = 'school_disciplines';

    protected $fillable = [
        'enrollment_id',
        'reported_by',
        'incident_date',
        'incident_type',
        'description',
        'sanction',
        'sanction_start',
        'sanction_end',
        'status',
        'parent_notified',
    ];

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
            'sanction_start' => 'date',
            'sanction_end' => 'date',
            'parent_notified' => 'boolean',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'reported_by');
    }
}
