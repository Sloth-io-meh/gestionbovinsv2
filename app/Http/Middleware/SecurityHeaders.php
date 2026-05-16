<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. Strict-Transport-Security (HSTS)
        // Force HTTPS for 1 year, include subdomains
        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // 2. Content-Security-Policy (CSP)
        // Restrict where scripts, styles, images, and other resources can be loaded from
        $response->header('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; upgrade-insecure-requests;");

        // 3. X-Frame-Options
        // Prevent clickjacking attacks by disallowing framing
        $response->header('X-Frame-Options', 'DENY');

        // 4. X-Content-Type-Options
        // Prevent MIME sniffing attacks
        $response->header('X-Content-Type-Options', 'nosniff');

        // 5. Referrer-Policy
        // Control how much referrer information is shared
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 6. Permissions-Policy
        // Restrict access to sensitive browser features
        $response->header('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), magnetometer=(), gyroscope=(), accelerometer=(), payment=()');

        // Remove X-Powered-By header (reveals PHP version to attackers)
        if ($response->headers->has('X-Powered-By')) {
            $response->headers->remove('X-Powered-By');
        }

        // Additional security headers
        // X-XSS-Protection (legacy, but doesn't hurt)
        $response->header('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}
