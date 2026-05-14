<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportCard extends Model
{
    protected $table = 'school_report_cards';

    protected $fillable = [
        'enrollment_id',
        'period',
        'average',
        'rank',
        'teacher_comment',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'average' => 'decimal:2',
            'generated_at' => 'date',
            'rank' => 'integer',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
