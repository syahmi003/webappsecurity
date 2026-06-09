<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeadersMiddleware
 *
 * XSS & CSRF PREVENTION — adds HTTP security headers to every response:
 *
 * - Content-Security-Policy: restricts which scripts/styles/sources can load (prevents XSS)
 * - X-Frame-Options: prevents clickjacking by blocking iframe embedding
 * - X-Content-Type-Options: prevents MIME-type sniffing attacks
 * - Referrer-Policy: limits referrer info sent to external sites
 * - Strict-Transport-Security: forces HTTPS connections (enable in production)
 * - Permissions-Policy: disables browser features not needed by the app
 */
class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. XSS PREVENTION — Content Security Policy
        // Only allow scripts/styles from same origin; block inline scripts from unknown sources
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; " .
            "font-src 'self' https://fonts.gstatic.com; " .
            "img-src 'self' data:; " .
            "object-src 'none'; " .
            "base-uri 'self'; " .
            "form-action 'self';"
        );

        // 2. CLICKJACKING PREVENTION — deny embedding in iframes
        $response->headers->set('X-Frame-Options', 'DENY');

        // 3. MIME SNIFFING PREVENTION
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 4. REFERRER POLICY — don't leak URL info to external sites
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. PERMISSIONS POLICY — disable unneeded browser features
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), payment=()'
        );

        // 6. HSTS — force HTTPS (uncomment for production with HTTPS)
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}
