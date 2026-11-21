<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * When a business's trial has ended, its grace period is over or it has cancelled, the
 * CRM stays readable but nothing can be changed until it chooses a plan. Billing and
 * signing out always work. Businesses without a subscription row are not limited.
 */
class EnforceSubscription
{
    /** Routes that must keep working while read-only. */
    private const ALWAYS_ALLOWED = ['crm.billing', 'crm.billing.*', 'logout', 'verification.*'];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethodSafe() || $request->routeIs(...self::ALWAYS_ALLOWED)) {
            return $next($request);
        }

        $subscription = Subscription::current();

        if ($subscription && $subscription->isReadOnly()) {
            $message = $subscription->status === 'trialing' || $subscription->status === 'read_only'
                ? 'Your account is read-only. Choose a plan to keep working.'
                : 'Your subscription has ended. Choose a plan to keep working.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 402);
            }

            return redirect()->route('crm.billing')->with('error', $message);
        }

        return $next($request);
    }
}
