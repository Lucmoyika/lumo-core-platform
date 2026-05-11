<?php

namespace Modules\University\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\University\Database\Factories\UniversityProgramFactory;

class UniversityProgram extends Model
{
    use HasFactory;

    protected $table = 'university_programs';

    protected $fillable = [
        'name',
        'slug',
        'headline',
        'description',
        'status',
        'audience',
        'capabilities',
        'metrics',
        'is_public',
        'sort_order',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'capabilities' => 'array',
            'metrics' => 'array',
            'settings' => 'array',
            'is_public' => 'boolean',
        ];
    }

    protected static function newFactory(): Factory
    {
        return UniversityProgramFactory::new();
    }
}
