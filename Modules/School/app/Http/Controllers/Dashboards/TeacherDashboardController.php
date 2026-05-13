<?php

namespace Modules\School\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Support\Facades\Auth;
use Modules\School\Models\Exam;
use Modules\School\Models\Grade;
use Modules\School\Models\Teacher;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');
        $user = Auth::user();

        $teacher = Teacher::where('email', $user->email)->first();
        $classes = $teacher ? $teacher->classes()->with('enrollments')->get() : collect();

        $stats = [
            'classes'        => $classes->count(),
            'students'       => $classes->sum(fn($c) => $c->enrollments->count()),
            'exams'          => $teacher ? Exam::whereIn('school_class_id', $classes->pluck('id'))->count() : 0,
            'grades_entered' => $teacher ? Grade::where('teacher_id', $teacher->id)->count() : 0,
        ];

        return view('school::dashboards.teacher', compact('module', 'teacher', 'classes', 'stats'));
    }
}
