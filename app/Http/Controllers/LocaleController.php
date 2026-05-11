<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    protected array $supported = ['fr', 'en', 'sw', 'ln'];

    public function switch(Request $request, string $locale)
    {
        if (!in_array($locale, $this->supported)) {
            abort(404);
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return redirect()->back()->withCookie(cookie()->forever('locale', $locale));
    }
}
