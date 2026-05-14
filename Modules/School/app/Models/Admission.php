<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admission extends Model
{
    protected $table = 'school_admissions';

    protected $fillable = [
        'student_id',
        'reference',
        'status',
        'applied_at',
        'approved_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'applied_at' => 'date',
            'approved_at' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
