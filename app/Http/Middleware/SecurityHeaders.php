<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Adds a handful of standard defensive headers. HSTS only goes out in
     * production — sending it over local HTTP would just be a no-op in
     * browsers, but there's no reason to send it before the site has HTTPS.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
