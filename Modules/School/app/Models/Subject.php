<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $table = 'school_subjects';

    protected $fillable = [
        'name',
        'code',
        'coefficient',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'coefficient' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'school_teacher_subject')
            ->withTimestamps();
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_subject_teacher')
            ->withPivot('teacher_id')
            ->withTimestamps();
    }

    public function timetableEntries(): HasMany
    {
        return $this->hasMany(TimetableEntry::class);
    }
}
