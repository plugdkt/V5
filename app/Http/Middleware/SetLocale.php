<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request and set the application locale based on session or cookie.
     */
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = ['th', 'en'];

        // ponytail: Simple session-based locale with fallback to 'th'
        $locale = Session::get('locale', config('app.locale', 'th'));

        if (!in_array($locale, $supportedLocales, true)) {
            $locale = 'th';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
