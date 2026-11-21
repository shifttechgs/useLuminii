<?php

/*
| useLuminii plans: the single source of truth for what each plan costs, how many users
| it includes and which CRM sections it unlocks. Billing charges from these numbers, and
| the sign-up and billing pages show them. Amounts are in rand (ZAR); annual prices are
| billed upfront for 10 months (2 months free).
|
| Features are CRM sections. A section not listed under a plan is shown with an
| "Upgrade to Business" page instead (see App\Http\Middleware\RequirePlanFeature).
*/

return [

    'currency' => 'ZAR',

    'trial_days' => 14,

    // Trials get these features so people can try everything before choosing.
    'trial_plan' => 'business',

    'plans' => [

        'starter' => [
            'name'          => 'Starter',
            'tagline'       => 'For solo operators: get found, quote and get paid.',
            'monthly'       => 999,
            'annual'        => 9990,
            'users'         => 1,
            'extra_user'    => null,          // Starter is one user; more users means Business
            'features'      => ['leads', 'clients', 'requests', 'pipeline', 'services', 'quotes', 'invoices'],
            'highlights'    => ['Website and Google presence', 'Receptionist, 24/7', 'Quotes and invoices, paid online', 'CRM, leads and pipeline', 'WhatsApp enquiries'],
        ],

        'business' => [
            'name'          => 'Business',
            'tagline'       => 'For teams running jobs, scheduling and finances in one flow.',
            'monthly'       => 1799,
            'annual'        => 17990,
            'users'         => 3,
            'extra_user'    => ['monthly' => 299, 'annual' => 2990],
            'features'      => ['leads', 'clients', 'requests', 'pipeline', 'services', 'quotes', 'jobs', 'calendar', 'invoices', 'recurring', 'expenses', 'reports'],
            'highlights'    => ['Everything in Starter', 'Jobs and team scheduling', 'Recurring invoices', 'Expenses and reports', '3 users included'],
        ],

    ],

    // Plan a section first appears in (for the "Upgrade to ..." page and nav tags).
    'feature_labels' => [
        'quotes'    => 'Quotes',
        'jobs'      => 'Jobs',
        'calendar'  => 'Job calendar',
        'invoices'  => 'Invoices',
        'recurring' => 'Recurring invoices',
        'expenses'  => 'Expenses',
        'reports'   => 'Reports',
    ],

];
