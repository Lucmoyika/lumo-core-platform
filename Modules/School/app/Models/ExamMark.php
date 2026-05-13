<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamMark extends Model
{
    protected $table = 'school_exam_marks';

    protected $fillable = [
        'exam_id',
        'enrollment_id',
        'score',
        'is_absent',
        'comment',
        'entered_by',
        'entered_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'is_absent' => 'boolean',
            'entered_at' => 'datetime',
        ];
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'entered_by');
    }

    public function getPercentageAttribute(): ?float
    {
        if ($this->score === null || (float) $this->exam->max_score === 0.0) {
            return null;
        }

        return round((float) $this->score / (float) $this->exam->max_score * 100, 2);
    }
}
