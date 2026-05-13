<?php

namespace Modules\School\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Support\Facades\Auth;
use Modules\School\Models\Attendance;
use Modules\School\Models\Grade;
use Modules\School\Models\SchoolParent;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');
        $user = Auth::user();

        $parent = SchoolParent::where('user_id', $user->id)
            ->with(['students.enrollments.grades', 'students.enrollments.attendances'])
            ->first();

        $children = $parent ? $parent->students : collect();

        $childData = $children->map(function ($student) {
            $enrollment = $student->enrollments()
                ->with('schoolClass.academicProgram')
                ->where('status', 'active')
                ->first();

            $recentGrades = $enrollment
                ? Grade::where('enrollment_id', $enrollment->id)->latest()->take(5)->get()
                : collect();

            $recentAttendance = $enrollment
                ? Attendance::where('enrollment_id', $enrollment->id)->latest()->take(5)->get()
                : collect();

            return compact('student', 'enrollment', 'recentGrades', 'recentAttendance');
        });

        $stats = [
            'children'       => $children->count(),
            'total_fees_due' => $children->sum(
                fn($s) => $s->enrollments->sum('fee_amount') - $s->enrollments->sum('fee_paid')
            ),
        ];

        return view('school::dashboards.parent', compact('module', 'parent', 'children', 'childData', 'stats'));
    }
}
