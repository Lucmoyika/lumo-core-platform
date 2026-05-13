<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;

class PreRegistration extends Model
{
    protected $table = 'school_pre_registrations';

    protected $fillable = [
        'reference',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'desired_class',
        'academic_year',
        'parent_name',
        'parent_email',
        'parent_phone',
        'address',
        'documents',
        'status',
        'notes',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'documents' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
