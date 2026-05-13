<?php

namespace Modules\School\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Support\Modules\ModuleRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\School\Models\PreRegistration;
use Modules\School\Models\SchoolClass;

class PreRegistrationController extends Controller
{
    // PUBLIC: show the online admission form
    public function showForm()
    {
        $module = ModuleRegistry::find('school');
        $classes = SchoolClass::where('status', 'active')->orderBy('level')->get();

        return view('school::public.admission', compact('module', 'classes'));
    }

    // PUBLIC: handle admission form submission
    public function submitForm(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'birth_date'    => 'required|date|before:-3 years',
            'gender'        => 'required|in:male,female',
            'desired_class' => 'required|string|max:100',
            'academic_year' => 'required|string|max:20',
            'parent_name'   => 'required|string|max:200',
            'parent_email'  => 'nullable|email|max:200',
            'parent_phone'  => 'required|string|max:30',
            'address'       => 'nullable|string|max:500',
        ]);

        $data['reference'] = 'PRE-' . date('Y') . '-' . strtoupper(Str::random(6));
        $data['status'] = 'pending';

        PreRegistration::create($data);

        return redirect()->route('school.admission')->with('success', 'Votre demande de pré-inscription (réf: ' . $data['reference'] . ') a été soumise avec succès. Notre équipe vous contactera bientôt.');
    }

    // ERP: list pre-registrations
    public function index(Request $request)
    {
        $module = ModuleRegistry::find('school');
        $query = PreRegistration::latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $registrations = $query->paginate(20)->withQueryString();

        $stats = [
            'pending'  => PreRegistration::where('status', 'pending')->count(),
            'approved' => PreRegistration::where('status', 'approved')->count(),
            'rejected' => PreRegistration::where('status', 'rejected')->count(),
        ];

        return view('school::erp.pre_registrations.index', compact('module', 'registrations', 'stats'));
    }

    // ERP: show and process a pre-registration
    public function show(PreRegistration $preRegistration)
    {
        $module = ModuleRegistry::find('school');

        return view('school::erp.pre_registrations.show', compact('module', 'preRegistration'));
    }

    public function approve(Request $request, PreRegistration $preRegistration)
    {
        $preRegistration->update(['status' => 'approved', 'reviewed_at' => now(), 'notes' => $request->notes]);

        return redirect()->route('school.erp.pre-registrations.index')->with('success', 'Pré-inscription approuvée.');
    }

    public function reject(Request $request, PreRegistration $preRegistration)
    {
        $preRegistration->update(['status' => 'rejected', 'reviewed_at' => now(), 'notes' => $request->notes]);

        return redirect()->route('school.erp.pre-registrations.index')->with('success', 'Pré-inscription rejetée.');
    }
}
