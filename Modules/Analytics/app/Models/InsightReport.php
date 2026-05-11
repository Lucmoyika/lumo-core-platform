<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Analytics\Database\Factories\InsightReportFactory;

class InsightReport extends Model
{
    use HasFactory;

    protected $table = 'insight_reports';

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
        return InsightReportFactory::new();
    }
}
