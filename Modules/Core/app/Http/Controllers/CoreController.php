<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoreController extends Controller
{
    public function home()
    {
        $modules = [
            ['name' => 'School', 'icon' => '🎓', 'description' => __('core::messages.school_desc'), 'route' => 'school.home', 'color' => 'indigo'],
            ['name' => 'University', 'icon' => '🏛️', 'description' => __('core::messages.university_desc'), 'route' => 'university.home', 'color' => 'blue'],
            ['name' => 'Companies', 'icon' => '🏢', 'description' => __('core::messages.companies_desc'), 'route' => 'companies.home', 'color' => 'emerald'],
            ['name' => 'Jobs', 'icon' => '💼', 'description' => __('core::messages.jobs_desc'), 'route' => 'jobs.home', 'color' => 'amber'],
            ['name' => 'E-Commerce', 'icon' => '🛒', 'description' => __('core::messages.ecommerce_desc'), 'route' => 'ecommerce.home', 'color' => 'rose'],
            ['name' => 'Payment', 'icon' => '💳', 'description' => __('core::messages.payment_desc'), 'route' => 'payment.home', 'color' => 'violet'],
            ['name' => 'Logistics', 'icon' => '🚚', 'description' => __('core::messages.logistics_desc'), 'route' => 'logistics.home', 'color' => 'orange'],
            ['name' => 'Communication', 'icon' => '💬', 'description' => __('core::messages.communication_desc'), 'route' => 'communication.home', 'color' => 'teal'],
            ['name' => 'Analytics', 'icon' => '📊', 'description' => __('core::messages.analytics_desc'), 'route' => 'analytics.home', 'color' => 'cyan'],
        ];
        return view('core::public.home', compact('modules'));
    }

    public function features()
    {
        return view('core::public.features');
    }

    public function pricing()
    {
        return view('core::public.pricing');
    }

    public function contact()
    {
        return view('core::public.contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: Send email notification
        return back()->with('success', __('core::messages.contact_sent'));
    }
}
