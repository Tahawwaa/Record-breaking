<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($locale = session('locale'), ['en', 'fa'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
