<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

/**
 * The business's plan: trial status, what each plan includes, seats used.
 * Paying with Paystack is added in the next step; until then choosing a plan goes
 * through the team.
 */
class BillingController extends Controller
{
    public function index()
    {
        return view('crm.billing.index', [
            'subscription' => Subscription::current(),
            'plans'        => config('plans.plans'),
            'trialDays'    => (int) config('plans.trial_days', 14),
        ]);
    }
}
