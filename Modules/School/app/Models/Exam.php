<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $table = 'school_exams';

    protected $fillable = [
        'name',
        'academic_year_id',
        'school_class_id',
        'subject',
        'exam_type',
        'period',
        'max_score',
        'date',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'max_score' => 'decimal:2',
            'date' => 'date',
        ];
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function examMarks(): HasMany
    {
        return $this->hasMany(ExamMark::class);
    }
}
