<?php

namespace Modules\School\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Modules\School\Models\AcademicYear;
use Modules\School\Models\Attendance;
use Modules\School\Models\Enrollment;
use Modules\School\Models\FeePayment;
use Modules\School\Models\News;
use Modules\School\Models\PreRegistration;
use Modules\School\Models\SchoolClass;
use Modules\School\Models\Student;
use Modules\School\Models\Teacher;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');

        $stats = [
            'students'          => Student::count(),
            'teachers'          => Teacher::count(),
            'classes'           => SchoolClass::count(),
            'enrollments'       => Enrollment::where('status', 'active')->count(),
            'pre_registrations' => PreRegistration::where('status', 'pending')->count(),
            'fee_collected'     => FeePayment::sum('amount'),
            'attendance_today'  => Attendance::where('date', today())->count(),
            'pending_news'      => News::where('is_published', false)->count(),
        ];

        $recentStudents = Student::latest()->take(5)->get();
        $recentEnrollments = Enrollment::with(['student', 'schoolClass'])->latest()->take(5)->get();
        $currentYear = AcademicYear::where('is_current', true)->first();

        return view('school::dashboards.admin', compact('module', 'stats', 'recentStudents', 'recentEnrollments', 'currentYear'));
    }
}
