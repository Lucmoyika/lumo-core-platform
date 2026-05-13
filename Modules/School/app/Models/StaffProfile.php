<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    protected $table = 'school_staff_profiles';

    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'role',
        'department',
        'email',
        'phone',
        'photo_path',
        'bio',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
