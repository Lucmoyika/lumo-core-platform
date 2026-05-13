<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\School\Database\Factories\StudentFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'school_students';

    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'email',
        'phone',
        'address',
        'parent_name',
        'parent_phone',
        'parent_email',
        'status',
        'photo_url',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(SchoolParent::class, 'school_parent_student')
            ->withPivot('relationship', 'is_primary')
            ->withTimestamps();
    }

    public function latestEnrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class)->latest();
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute(): int
    {
        return $this->birth_date->age;
    }

    protected static function newFactory(): Factory
    {
        return StudentFactory::new();
    }
}
