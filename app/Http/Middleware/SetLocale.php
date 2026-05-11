<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    protected array $supportedLocales = ['fr', 'en', 'sw', 'ln'];

    public function handle(Request $request, Closure $next)
    {
        $locale = $this->resolveLocale($request);
        App::setLocale($locale);
        Session::put('locale', $locale);

        $response = $next($request);
        $response->withCookie(Cookie::forever('locale', $locale));

        return $response;
    }

    protected function resolveLocale(Request $request): string
    {
        // 1. URL segment (e.g. /fr/..., /en/...)
        $segment = $request->segment(1);
        if ($segment && in_array($segment, $this->supportedLocales)) {
            return $segment;
        }

        // 2. Query param ?lang=fr
        if ($lang = $request->query('lang')) {
            if (in_array($lang, $this->supportedLocales)) {
                return $lang;
            }
        }

        // 3. Session
        if ($locale = Session::get('locale')) {
            if (in_array($locale, $this->supportedLocales)) {
                return $locale;
            }
        }

        // 4. Cookie
        if ($locale = $request->cookie('locale')) {
            if (in_array($locale, $this->supportedLocales)) {
                return $locale;
            }
        }

        // 5. Browser Accept-Language
        $browserLocale = substr($request->getPreferredLanguage($this->supportedLocales) ?? 'fr', 0, 2);
        if (in_array($browserLocale, $this->supportedLocales)) {
            return $browserLocale;
        }

        return config('app.locale', 'fr');
    }
}
