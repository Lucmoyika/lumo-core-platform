<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\School\Database\Factories\AcademicProgramFactory;

class AcademicProgram extends Model
{
    use HasFactory;

    protected $table = 'academic_programs';

    protected $fillable = [
        'name',
        'slug',
        'headline',
        'description',
        'status',
        'audience',
        'level',
        'duration_months',
        'annual_fee',
        'capabilities',
        'metrics',
        'is_public',
        'admission_open',
        'admission_deadline',
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
            'admission_open' => 'boolean',
            'admission_deadline' => 'date',
            'duration_months' => 'integer',
            'annual_fee' => 'decimal:2',
        ];
    }

    protected static function newFactory(): Factory
    {
        return AcademicProgramFactory::new();
    }
}
