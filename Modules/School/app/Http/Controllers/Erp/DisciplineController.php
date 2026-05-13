<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\Discipline;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Teacher;

class DisciplineController extends Controller
{
    public function index(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $query = Discipline::with('enrollment.student', 'enrollment.schoolClass')->latest('incident_date');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->get('type')) {
            $query->where('incident_type', $type);
        }

        $disciplines = $query->paginate(20);

        $stats = [
            'open'   => Discipline::where('status', 'open')->count(),
            'closed' => Discipline::where('status', 'closed')->count(),
            'today'  => Discipline::whereDate('incident_date', today())->count(),
        ];

        return view('school::erp.discipline.index', compact('module', 'disciplines', 'stats'));
    }

    public function create()
    {
        $module = ModuleRegistry::find('school');
        $enrollments = Enrollment::with('student', 'schoolClass')->where('status', 'active')->get();
        $teachers = Teacher::where('status', 'active')->get();
        $incidentTypes = ['absence', 'late', 'misconduct', 'violence', 'cheating', 'other'];

        return view('school::erp.discipline.create', compact('module', 'enrollments', 'teachers', 'incidentTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'enrollment_id'   => 'required|exists:school_enrollments,id',
            'reported_by'     => 'nullable|exists:school_teachers,id',
            'incident_date'   => 'required|date',
            'incident_type'   => 'required|in:absence,late,misconduct,violence,cheating,other',
            'description'     => 'required|string',
            'sanction'        => 'nullable|string|max:200',
            'sanction_start'  => 'nullable|date',
            'sanction_end'    => 'nullable|date|after_or_equal:sanction_start',
            'status'          => 'required|in:open,closed,appealed',
            'parent_notified' => 'boolean',
        ]);

        Discipline::create($data);

        return redirect()->route('school.erp.discipline.index')->with('success', 'Incident enregistré.');
    }

    public function show(Discipline $discipline)
    {
        $module = ModuleRegistry::find('school');
        $discipline->load('enrollment.student', 'enrollment.schoolClass', 'reportedBy');

        return view('school::erp.discipline.show', compact('module', 'discipline'));
    }

    public function update(Request $request, Discipline $discipline)
    {
        $data = $request->validate([
            'status'          => 'required|in:open,closed,appealed',
            'sanction'        => 'nullable|string|max:200',
            'sanction_end'    => 'nullable|date',
            'parent_notified' => 'boolean',
        ]);

        $discipline->update($data);

        return redirect()->route('school.erp.discipline.show', $discipline)->with('success', 'Mis à jour.');
    }
}
