<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class ThrottleContactForm
{
    /**
     * Handle an incoming request.
     * Rate limit: 3 submissions per IP per hour
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $key = 'contact-form:' . $request->ip();

        // Allow 3 attempts per hour
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);

            Log::warning('Contact form rate limit exceeded', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'retry_after' => $minutes
            ]);

            return response()->json([
                'success' => false,
                'message' => "Too many contact form submissions. Please try again in {$minutes} minutes.",
                'errors' => ['rate_limit' => 'Rate limit exceeded']
            ], 429);
        }

        // Increment the attempt counter (expires in 1 hour)
        RateLimiter::hit($key, 3600);

        return $next($request);
    }
}
