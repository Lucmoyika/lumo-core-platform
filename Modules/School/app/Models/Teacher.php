<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\School\Database\Factories\TeacherFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'school_teachers';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialty',
        'qualification',
        'hired_at',
        'status',
        'photo_url',
        'subjects',
    ];

    protected function casts(): array
    {
        return [
            'subjects' => 'array',
            'hired_at' => 'date',
        ];
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_teacher')
            ->withPivot('subject', 'role')
            ->withTimestamps();
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }

    public function enteredExamMarks(): HasMany
    {
        return $this->hasMany(ExamMark::class, 'entered_by');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected static function newFactory(): Factory
    {
        return TeacherFactory::new();
    }
}
