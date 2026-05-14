<?php

namespace Modules\School\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\School\Models\Admission;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Grade;
use Modules\School\Models\Invoice;
use Modules\School\Models\ParentGuardian;
use Modules\School\Models\Payment;
use Modules\School\Models\ReportCard;
use Modules\School\Models\SchoolClass;
use Modules\School\Models\Student;
use Modules\School\Models\Subject;
use Modules\School\Models\Teacher;
use Modules\School\Models\TimetableEntry;

class SchoolErpService
{
    public function adminDashboardData(): array
    {
        $attendanceRate = round((float) DB::table('school_attendances')
            ->selectRaw('AVG(CASE WHEN status = ? THEN 100 ELSE 0 END) as attendance_rate', ['present'])
            ->value('attendance_rate'), 1);

        $monthlyRevenue = Payment::query()
            ->get()
            ->groupBy(fn (Payment $payment): string => $payment->paid_at?->format('Y-m') ?? now()->format('Y-m'))
            ->map(fn (Collection $rows, string $month): object => (object) [
                'month' => $month,
                'amount' => (float) $rows->sum('amount'),
            ])
            ->sortBy('month')
            ->values();

        $revenueByClass = Invoice::query()
            ->join('school_enrollments', 'school_enrollments.id', '=', 'school_invoices.enrollment_id')
            ->join('school_classes', 'school_classes.id', '=', 'school_enrollments.school_class_id')
            ->selectRaw('school_classes.name as class_name, SUM(school_invoices.paid_amount) as revenue')
            ->groupBy('school_classes.name')
            ->orderByDesc('revenue')
            ->limit(6)
            ->get();

        return [
            'totals' => [
                'students' => Student::count(),
                'teachers' => Teacher::count(),
                'classes' => SchoolClass::count(),
                'revenue' => (float) Payment::sum('amount'),
                'attendance_rate' => $attendanceRate,
            ],
            'charts' => [
                'monthly_revenue' => $monthlyRevenue,
                'revenue_by_class' => $revenueByClass,
            ],
            'unpaid_alerts' => Invoice::query()
                ->with('enrollment.student')
                ->where('status', '!=', 'paid')
                ->whereDate('due_date', '<=', now()->toDateString())
                ->orderBy('due_date')
                ->limit(10)
                ->get(),
            'workflow' => [
                'admissions' => Admission::count(),
                'enrollments' => Enrollment::count(),
                'attendances' => DB::table('school_attendances')->count(),
                'exams' => DB::table('school_exams')->count(),
                'marks' => Grade::count(),
                'report_cards' => ReportCard::count(),
                'payments' => Payment::count(),
            ],
        ];
    }

    public function teacherDashboardData(?int $teacherId = null): array
    {
        $teacher = $teacherId
            ? Teacher::with(['classes', 'timetableEntries.subject', 'timetableEntries.schoolClass'])->findOrFail($teacherId)
            : Teacher::with(['classes', 'timetableEntries.subject', 'timetableEntries.schoolClass'])->firstOrFail();

        $todayDow = Carbon::now()->dayOfWeekIso;
        $assignedClassIds = $teacher->classes()->pluck('school_classes.id');

        return [
            'teacher' => $teacher,
            'assigned_classes' => $teacher->classes,
            'today_schedule' => $teacher->timetableEntries->where('day_of_week', $todayDow)->sortBy('starts_at')->values(),
            'students' => Student::query()
                ->whereHas('enrollments', fn ($q) => $q->whereIn('school_class_id', $assignedClassIds))
                ->orderBy('last_name')
                ->limit(80)
                ->get(),
            'mark_entry_shortcut' => Grade::query()
                ->with(['enrollment.student'])
                ->where('teacher_id', $teacher->id)
                ->latest('graded_at')
                ->limit(8)
                ->get(),
        ];
    }

    public function studentDashboardData(?int $studentId = null): array
    {
        $student = $studentId
            ? Student::with(['enrollments.schoolClass.timetableEntries.subject', 'enrollments.grades', 'enrollments.attendances'])->findOrFail($studentId)
            : Student::with(['enrollments.schoolClass.timetableEntries.subject', 'enrollments.grades', 'enrollments.attendances'])->firstOrFail();

        $activeEnrollment = $student->enrollments->sortByDesc('id')->first();

        return [
            'student' => $student,
            'timetable' => $activeEnrollment?->schoolClass?->timetableEntries?->sortBy(['day_of_week', 'starts_at'])->values() ?? collect(),
            'marks' => $activeEnrollment?->grades?->sortByDesc('graded_at')->values() ?? collect(),
            'attendance_rate' => $activeEnrollment?->attendance_rate ?? 0,
        ];
    }

    public function parentDashboardData(?int $parentId = null): array
    {
        $parent = $parentId
            ? ParentGuardian::with(['students.enrollments.invoices', 'students.enrollments.reportCards'])->findOrFail($parentId)
            : ParentGuardian::with(['students.enrollments.invoices', 'students.enrollments.reportCards'])->firstOrFail();

        $children = $parent->students;

        $payments = Invoice::query()
            ->whereIn('enrollment_id', Enrollment::query()->whereIn('student_id', $children->pluck('id'))->pluck('id'))
            ->orderByDesc('due_date')
            ->limit(20)
            ->get();

        return [
            'parent' => $parent,
            'children' => $children,
            'payments' => $payments,
            'results' => ReportCard::query()
                ->with('enrollment.student')
                ->whereIn('enrollment_id', Enrollment::query()->whereIn('student_id', $children->pluck('id'))->pluck('id'))
                ->orderByDesc('generated_at')
                ->limit(20)
                ->get(),
        ];
    }

    public function timetableData(?int $classId = null): array
    {
        $classes = SchoolClass::query()->orderBy('level')->orderBy('section')->get();
        $selected = $classId ? $classes->firstWhere('id', $classId) : $classes->first();

        $entries = TimetableEntry::query()
            ->with(['teacher', 'subject', 'schoolClass'])
            ->when($selected, fn ($q) => $q->where('school_class_id', $selected->id))
            ->orderBy('day_of_week')
            ->orderBy('starts_at')
            ->get();

        $conflicts = $entries->filter(fn (TimetableEntry $entry): bool => $this->hasTeacherConflict($entry));

        return [
            'classes' => $classes,
            'selected_class' => $selected,
            'entries' => $entries,
            'conflicts' => $conflicts->pluck('id')->all(),
            'weekdays' => [1 => 'Lun', 2 => 'Mar', 3 => 'Mer', 4 => 'Jeu', 5 => 'Ven', 6 => 'Sam', 7 => 'Dim'],
        ];
    }

    public function hasTeacherConflict(TimetableEntry $entry): bool
    {
        return TimetableEntry::query()
            ->where('teacher_id', $entry->teacher_id)
            ->where('day_of_week', $entry->day_of_week)
            ->where('id', '!=', $entry->id)
            ->where(function ($query) use ($entry): void {
                $query->whereBetween('starts_at', [$entry->starts_at, $entry->ends_at])
                    ->orWhereBetween('ends_at', [$entry->starts_at, $entry->ends_at])
                    ->orWhere(function ($q) use ($entry): void {
                        $q->where('starts_at', '<=', $entry->starts_at)
                            ->where('ends_at', '>=', $entry->ends_at);
                    });
            })
            ->exists();
    }

    public function reportCardData(Enrollment $enrollment, string $period): array
    {
        $enrollment->loadMissing(['student', 'schoolClass', 'grades.teacher', 'attendances']);

        $subjects = $enrollment->grades
            ->where('period', $period)
            ->groupBy('subject')
            ->map(function (Collection $grades): array {
                $average = round((float) $grades->avg(fn (Grade $grade) => $grade->percentage), 2);

                return [
                    'subject' => $grades->first()->subject,
                    'average' => $average,
                    'teacher' => $grades->first()->teacher?->full_name,
                ];
            })
            ->values();

        $average = round((float) $subjects->avg('average'), 2);
        $ranking = $this->rankingForClass((int) $enrollment->school_class_id, $period);
        $rank = $ranking->search(fn (array $row): bool => (int) $row['enrollment_id'] === (int) $enrollment->id);

        $reportCard = ReportCard::updateOrCreate(
            ['enrollment_id' => $enrollment->id, 'period' => $period],
            [
                'average' => $average,
                'rank' => $rank === false ? null : $rank + 1,
                'teacher_comment' => $this->teacherComment($average, $enrollment->attendance_rate),
                'generated_at' => now()->toDateString(),
            ]
        );

        return [
            'enrollment' => $enrollment,
            'period' => $period,
            'subjects' => $subjects,
            'average' => $average,
            'rank' => $reportCard->rank,
            'attendance_rate' => $enrollment->attendance_rate,
            'report_card' => $reportCard,
            'ranking' => $ranking,
        ];
    }

    public function rankingForClass(int $classId, string $period): Collection
    {
        return Enrollment::query()
            ->where('school_class_id', $classId)
            ->with(['student', 'grades'])
            ->get()
            ->map(function (Enrollment $enrollment) use ($period): array {
                $periodGrades = $enrollment->grades->where('period', $period);
                $average = round((float) $periodGrades->avg(fn (Grade $grade) => $grade->percentage), 2);

                return [
                    'enrollment_id' => $enrollment->id,
                    'student' => $enrollment->student?->full_name,
                    'average' => $average,
                ];
            })
            ->sortByDesc('average')
            ->values();
    }

    public function feesData(): array
    {
        $invoices = Invoice::query()
            ->with('enrollment.student')
            ->orderBy('due_date')
            ->paginate(20);

        return [
            'invoices' => $invoices,
            'totals' => [
                'invoiced' => (float) Invoice::sum('amount'),
                'paid' => (float) Invoice::sum('paid_amount'),
                'balance' => (float) Invoice::sum(DB::raw('amount - paid_amount')),
            ],
            'alerts' => Invoice::query()
                ->with('enrollment.student')
                ->where('status', '!=', 'paid')
                ->whereDate('due_date', '<', now()->toDateString())
                ->orderBy('due_date')
                ->get(),
        ];
    }

    public function generateInvoicesForCurrentEnrollments(): int
    {
        $created = 0;

        Enrollment::query()->each(function (Enrollment $enrollment) use (&$created): void {
            $exists = Invoice::query()
                ->where('enrollment_id', $enrollment->id)
                ->whereYear('created_at', now()->year)
                ->exists();

            if ($exists) {
                return;
            }

            Invoice::create([
                'enrollment_id' => $enrollment->id,
                'invoice_number' => 'INV-' . now()->format('Y') . '-' . str_pad((string) ($enrollment->id), 5, '0', STR_PAD_LEFT),
                'amount' => $enrollment->fee_amount,
                'paid_amount' => min((float) $enrollment->fee_paid, (float) $enrollment->fee_amount),
                'currency' => $enrollment->fee_currency,
                'due_date' => now()->endOfMonth()->toDateString(),
                'status' => ((float) $enrollment->fee_paid >= (float) $enrollment->fee_amount) ? 'paid' : 'partial',
            ]);
            $created++;
        });

        return $created;
    }

    public function promoteClass(int $fromClassId, int $toClassId, string $currentYear, string $nextYear): int
    {
        $promoted = 0;

        Enrollment::query()
            ->where('school_class_id', $fromClassId)
            ->where('school_year', $currentYear)
            ->with(['attendances', 'grades'])
            ->get()
            ->each(function (Enrollment $enrollment) use ($toClassId, $nextYear, &$promoted): void {
                if ($enrollment->average_mark < 50 || $enrollment->attendance_rate < 70) {
                    return;
                }

                Enrollment::firstOrCreate(
                    [
                        'student_id' => $enrollment->student_id,
                        'school_class_id' => $toClassId,
                        'school_year' => $nextYear,
                    ],
                    [
                        'status' => 'active',
                        'fee_amount' => $enrollment->fee_amount,
                        'fee_paid' => 0,
                        'fee_currency' => $enrollment->fee_currency,
                        'enrolled_at' => now()->toDateString(),
                    ]
                );

                $promoted++;
            });

        return $promoted;
    }

    private function teacherComment(float $average, float $attendanceRate): string
    {
        if ($average >= 80 && $attendanceRate >= 90) {
            return 'Excellent trimestre: résultats solides et assiduité exemplaire.';
        }

        if ($average >= 60) {
            return 'Bon trimestre: poursuivre les efforts et consolider les matières clés.';
        }

        return 'Des mesures de remédiation sont recommandées pour améliorer les performances.';
    }
}
