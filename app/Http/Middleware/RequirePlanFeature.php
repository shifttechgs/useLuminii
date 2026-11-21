<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sections that are part of a higher plan (config/plans.php) show an upgrade page
 * instead. Usage: ->middleware('plan.feature:quotes'). Trials get every Business
 * section; businesses without a subscription row are not limited.
 */
class RequirePlanFeature
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $subscription = Subscription::current();

        if (! $subscription || $subscription->hasFeature($feature)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'This is part of the Business plan.'], 403);
        }

        return response()->view('crm.billing.upgrade', [
            'feature' => config("plans.feature_labels.{$feature}", ucfirst($feature)),
        ], 403);
    }
}
