<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Modules\School\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('program_type')->orderBy('name')->paginate(30);
        $module = ModuleRegistry::find('school');

        return view('school::erp.subjects.index', compact('subjects', 'module'));
    }

    public function create()
    {
        $module = ModuleRegistry::find('school');
        $programTypes = ['maternelle', 'primaire', 'secondaire', 'humanites'];

        return view('school::erp.subjects.create', compact('module', 'programTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'code'         => 'nullable|string|max:20',
            'description'  => 'nullable|string',
            'program_type' => 'required|in:maternelle,primaire,secondaire,humanites',
            'coefficient'  => 'required|integer|min:1|max:10',
            'is_active'    => 'boolean',
        ]);

        Subject::create($data);

        return redirect()->route('school.erp.subjects.index')->with('success', 'Matière créée.');
    }

    public function edit(Subject $subject)
    {
        $module = ModuleRegistry::find('school');
        $programTypes = ['maternelle', 'primaire', 'secondaire', 'humanites'];

        return view('school::erp.subjects.edit', compact('module', 'subject', 'programTypes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'code'         => 'nullable|string|max:20',
            'description'  => 'nullable|string',
            'program_type' => 'required|in:maternelle,primaire,secondaire,humanites',
            'coefficient'  => 'required|integer|min:1|max:10',
            'is_active'    => 'boolean',
        ]);

        $subject->update($data);

        return redirect()->route('school.erp.subjects.index')->with('success', 'Mise à jour effectuée.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('school.erp.subjects.index')->with('success', 'Supprimé.');
    }
}
