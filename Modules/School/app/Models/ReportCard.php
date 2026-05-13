<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportCard extends Model
{
    protected $table = 'school_report_cards';

    protected $fillable = [
        'enrollment_id',
        'period',
        'average',
        'rank',
        'total_students',
        'general_comment',
        'teacher_comment',
        'director_comment',
        'conduct',
        'absences',
        'generated_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'average' => 'decimal:2',
            'generated_at' => 'datetime',
            'absences' => 'integer',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function getPassAttribute(): bool
    {
        return $this->average !== null && (float) $this->average >= 10;
    }
}
