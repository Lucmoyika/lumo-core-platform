<?php

namespace Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('identity::profile.show', ['user' => Auth::user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'locale' => ['nullable', 'in:fr,en,sw,ln'],
        ]);

        $user->update($request->only('name', 'email', 'phone', 'locale'));

        if ($request->filled('locale')) {
            session()->put('locale', $request->string('locale'));
        }

        return back()->with('success', __('identity::messages.profile_updated'));
    }

    public function settings()
    {
        return view('identity::profile.settings', ['user' => Auth::user()]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (! Hash::check($request->string('current_password'), Auth::user()->password)) {
            return back()->withErrors(['current_password' => __('identity::messages.wrong_password')]);
        }

        Auth::user()->update(['password' => Hash::make($request->string('password'))]);

        return back()->with('success', __('identity::messages.password_updated'));
    }
}
