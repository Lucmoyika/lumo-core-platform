<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\Attendance;
use Modules\School\Models\Enrollment;
use Modules\School\Models\SchoolClass;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $classes = SchoolClass::where('status', 'active')->orderBy('name')->get();
        $date = $request->get('date', today()->format('Y-m-d'));
        $classId = $request->get('class_id');
        $attendances = collect();
        $enrollments = collect();

        if ($classId) {
            $enrollments = Enrollment::with('student')
                ->where('school_class_id', $classId)
                ->where('status', 'active')
                ->get();

            $attendances = Attendance::whereIn('enrollment_id', $enrollments->pluck('id'))
                ->where('date', $date)
                ->pluck('status', 'enrollment_id');
        }

        $stats = [
            'today_present' => Attendance::where('date', today())->where('status', 'present')->count(),
            'today_absent'  => Attendance::where('date', today())->where('status', 'absent')->count(),
            'today_late'    => Attendance::where('date', today())->where('status', 'late')->count(),
        ];

        return view('school::erp.attendance.index', compact('module', 'classes', 'enrollments', 'attendances', 'date', 'classId', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id'   => 'required|exists:school_classes,id',
            'date'       => 'required|date',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $enrollmentId => $status) {
            Attendance::updateOrCreate(
                ['enrollment_id' => $enrollmentId, 'date' => $request->date],
                ['status' => $status, 'notified' => false]
            );
        }

        return redirect()->back()->with('success', 'Présences enregistrées.');
    }

    public function report(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $classes = SchoolClass::where('status', 'active')->orderBy('name')->get();
        $classId = $request->get('class_id');
        $month = $request->get('month', now()->format('Y-m'));
        $data = collect();

        if ($classId) {
            $enrollments = Enrollment::with('student')
                ->where('school_class_id', $classId)
                ->where('status', 'active')
                ->get();

            foreach ($enrollments as $enrollment) {
                $summary = Attendance::where('enrollment_id', $enrollment->id)
                    ->whereRaw("DATE_FORMAT(date,'%Y-%m') = ?", [$month])
                    ->selectRaw("status, COUNT(*) as count")
                    ->groupBy('status')
                    ->pluck('count', 'status');

                $data->push(['student' => $enrollment->student, 'summary' => $summary]);
            }
        }

        return view('school::erp.attendance.report', compact('module', 'classes', 'classId', 'month', 'data'));
    }
}
