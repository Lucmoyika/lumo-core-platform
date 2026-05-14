<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\School\Database\Factories\EnrollmentFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'school_enrollments';

    protected $fillable = [
        'student_id',
        'school_class_id',
        'school_year',
        'status',
        'fee_amount',
        'fee_paid',
        'fee_currency',
        'enrolled_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'notes' => 'array',
            'fee_amount' => 'decimal:2',
            'fee_paid' => 'decimal:2',
            'enrolled_at' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function reportCards(): HasMany
    {
        return $this->hasMany(ReportCard::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAttendanceRateAttribute(): float
    {
        $total = $this->attendances()->count();
        if ($total === 0) {
            return 0;
        }

        $present = $this->attendances()->where('status', 'present')->count();

        return round(($present / $total) * 100, 1);
    }

    public function getAverageMarkAttribute(): float
    {
        $avg = $this->grades()->selectRaw('AVG((score / NULLIF(max_score, 0)) * 100) as avg_pct')->value('avg_pct');

        return round((float) ($avg ?? 0), 2);
    }

    public function getFeeBalanceAttribute(): float
    {
        return (float) $this->fee_amount - (float) $this->fee_paid;
    }

    protected static function newFactory(): Factory
    {
        return EnrollmentFactory::new();
    }
}
