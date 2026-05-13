<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'school_subjects';

    protected $fillable = [
        'name',
        'code',
        'description',
        'program_type',
        'coefficient',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'coefficient' => 'integer',
        ];
    }
}
