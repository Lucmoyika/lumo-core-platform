<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\AcademicYear;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::latest()->paginate(20);
        $module = ModuleRegistry::find('school');

        return view('school::erp.academic_years.index', compact('years', 'module'));
    }

    public function create()
    {
        $module = ModuleRegistry::find('school');

        return view('school::erp.academic_years.create', compact('module'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:20|unique:school_academic_years',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_current' => 'boolean',
            'status'     => 'required|in:active,inactive',
        ]);

        if (!empty($data['is_current'])) {
            AcademicYear::where('is_current', true)->update(['is_current' => false]);
        }

        AcademicYear::create($data);

        return redirect()->route('school.erp.academic-years.index')->with('success', 'Année académique créée.');
    }

    public function edit(AcademicYear $academicYear)
    {
        $module = ModuleRegistry::find('school');

        return view('school::erp.academic_years.edit', compact('module', 'academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:20|unique:school_academic_years,name,' . $academicYear->id,
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_current' => 'boolean',
            'status'     => 'required|in:active,inactive',
        ]);

        if (!empty($data['is_current'])) {
            AcademicYear::where('is_current', true)->where('id', '!=', $academicYear->id)->update(['is_current' => false]);
        }

        $academicYear->update($data);

        return redirect()->route('school.erp.academic-years.index')->with('success', 'Mise à jour effectuée.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return redirect()->route('school.erp.academic-years.index')->with('success', 'Supprimé.');
    }
}
