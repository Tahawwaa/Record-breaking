<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // An explicit in-session choice (the EN/FA nav toggle) wins; otherwise
        // fall back to the signed-in user's saved preference.
        $locale = session('locale') ?? Auth::user()?->locale;

        if (in_array($locale, ['en', 'fa'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
