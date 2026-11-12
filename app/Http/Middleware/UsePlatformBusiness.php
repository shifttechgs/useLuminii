<?php

namespace App\Http\Middleware;

use App\Support\CurrentBusiness;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Public useLuminii website forms (contact, book a demo, Personal early access) always
 * work for the platform business, even when a CRM user of another business is signed in
 * in the same browser.
 */
class UsePlatformBusiness
{
    public function handle(Request $request, Closure $next): Response
    {
        return CurrentBusiness::run(CurrentBusiness::platform(), fn () => $next($request));
    }
}
