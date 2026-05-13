<?php

namespace Modules\School\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Modules\School\Models\Attendance;
use Modules\School\Models\PreRegistration;
use Modules\School\Models\Student;

class ReceptionistDashboardController extends Controller
{
    public function index()
    {
        $module = ModuleRegistry::find('school');

        $stats = [
            'pre_registrations_pending' => PreRegistration::where('status', 'pending')->count(),
            'pre_registrations_today'   => PreRegistration::whereDate('created_at', today())->count(),
            'students_active'           => Student::where('status', 'active')->count(),
            'attendance_today'          => Attendance::where('date', today())->count(),
        ];

        $pendingRegistrations = PreRegistration::where('status', 'pending')->latest()->take(10)->get();

        return view('school::dashboards.receptionist', compact('module', 'stats', 'pendingRegistrations'));
    }
}
