<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\SchoolClass;
use Modules\School\Models\Teacher;
use Modules\School\Models\Timetable;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $classes = SchoolClass::where('status', 'active')->orderBy('name')->get();
        $classId = $request->get('class_id');
        $timetable = collect();

        if ($classId) {
            $entries = Timetable::with('teacher')
                ->where('school_class_id', $classId)
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();

            for ($day = 0; $day <= 5; $day++) {
                $timetable[$day] = $entries->where('day_of_week', $day)->values();
            }
        }

        return view('school::erp.timetable.index', compact('module', 'classes', 'classId', 'timetable'));
    }

    public function create(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $classes = SchoolClass::where('status', 'active')->orderBy('name')->get();
        $teachers = Teacher::where('status', 'active')->orderBy('last_name')->get();
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        return view('school::erp.timetable.create', compact('module', 'classes', 'teachers', 'days'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'teacher_id'      => 'nullable|exists:school_teachers,id',
            'subject'         => 'required|string|max:100',
            'day_of_week'     => 'required|integer|min:0|max:6',
            'start_time'      => 'required|date_format:H:i',
            'end_time'        => 'required|date_format:H:i|after:start_time',
            'room'            => 'nullable|string|max:50',
            'academic_year'   => 'required|string|max:20',
        ]);

        // Conflict detection: same class, same day, overlapping time
        $conflict = Timetable::where('school_class_id', $data['school_class_id'])
            ->where('day_of_week', $data['day_of_week'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                  ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']]);
            })->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'Conflit détecté avec un autre cours.'])->withInput();
        }

        Timetable::create($data);

        return redirect()->route('school.erp.timetable.index', ['class_id' => $data['school_class_id']])->with('success', 'Cours ajouté.');
    }

    public function destroy(Timetable $timetable)
    {
        $classId = $timetable->school_class_id;
        $timetable->delete();

        return redirect()->route('school.erp.timetable.index', ['class_id' => $classId])->with('success', 'Supprimé.');
    }
}
