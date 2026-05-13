<?php

namespace Modules\School\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Support\Facades\Auth;
use Modules\School\Models\Attendance;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Grade;
use Modules\School\Models\ReportCard;
use Modules\School\Models\Student;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');
        $user = Auth::user();

        $student = Student::where('email', $user->email)->first();

        $enrollment = $student
            ? Enrollment::with(['schoolClass.academicProgram'])
                ->where('student_id', $student->id)
                ->where('status', 'active')
                ->latest()
                ->first()
            : null;

        $grades = $enrollment
            ? Grade::where('enrollment_id', $enrollment->id)->orderBy('subject')->get()
            : collect();

        $attendance = $enrollment
            ? Attendance::where('enrollment_id', $enrollment->id)->latest()->take(10)->get()
            : collect();

        $reportCards = $enrollment
            ? ReportCard::where('enrollment_id', $enrollment->id)->get()
            : collect();

        $stats = [
            'grades_count' => $grades->count(),
            'average'      => $grades->count() ? round($grades->avg('score'), 2) : null,
            'absences'     => $enrollment
                ? Attendance::where('enrollment_id', $enrollment->id)->where('status', 'absent')->count()
                : 0,
            'fee_balance'  => $enrollment ? $enrollment->fee_balance : 0,
        ];

        return view('school::dashboards.student', compact('module', 'student', 'enrollment', 'grades', 'attendance', 'reportCards', 'stats'));
    }
}
