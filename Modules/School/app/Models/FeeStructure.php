<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeStructure extends Model
{
    protected $table = 'school_fee_structures';

    protected $fillable = [
        'name',
        'academic_program_id',
        'academic_year',
        'amount',
        'currency',
        'fee_type',
        'due_date',
        'is_mandatory',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'due_date' => 'date',
            'is_mandatory' => 'boolean',
        ];
    }

    public function academicProgram(): BelongsTo
    {
        return $this->belongsTo(AcademicProgram::class);
    }

    public function feePayments(): HasMany
    {
        return $this->hasMany(FeePayment::class, 'fee_structure_id');
    }
}
