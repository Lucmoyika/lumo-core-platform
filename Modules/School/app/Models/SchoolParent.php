<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolParent extends Model
{
    protected $table = 'school_parents';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'occupation',
        'relationship_type',
        'status',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'school_parent_student')
            ->withPivot('relationship', 'is_primary')
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
