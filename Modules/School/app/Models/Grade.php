<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\School\Database\Factories\GradeFactory;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'school_grades';

    protected $fillable = [
        'enrollment_id',
        'teacher_id',
        'exam_id',
        'subject',
        'period',
        'score',
        'max_score',
        'grade_letter',
        'comment',
        'graded_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'max_score' => 'decimal:2',
            'graded_at' => 'date',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function getPercentageAttribute(): float
    {
        if ((float) $this->max_score === 0.0) {
            return 0;
        }

        return round(((float) $this->score / (float) $this->max_score) * 100, 1);
    }

    protected static function newFactory(): Factory
    {
        return GradeFactory::new();
    }
}
