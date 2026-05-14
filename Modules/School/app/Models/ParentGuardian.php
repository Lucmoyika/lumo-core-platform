<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ParentGuardian extends Model
{
    protected $table = 'school_parents';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'relationship',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'school_parent_student', 'parent_id', 'student_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }
}
