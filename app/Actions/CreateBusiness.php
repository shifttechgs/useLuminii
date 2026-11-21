<?php

namespace App\Actions;

use App\Models\BusinessSetup;
use App\Models\Subscription;
use App\Models\User;
use App\Support\CurrentBusiness;
use Database\Seeders\ExpenseCategorySeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Sets up a new, separate business: its settings, default expense categories, an owner
 * (Admin) who can sign in to the CRM, and its subscription. Used by self-serve sign-up
 * (a 14-day trial) and by `php artisan crm:create-business` (complimentary, set up by hand).
 */
class CreateBusiness
{
    /**
     * @param  array{name: string, owner_name: string, owner_email: string, password: string, phone?: ?string,
     *               currency?: string, timezone?: ?string}  $data
     * @param  array{plan: string, interval: string}|null  $trial  null = complimentary (set up by hand)
     * @return array{business_id: string, user: User, subscription: Subscription}
     */
    public function handle(array $data, ?array $trial = null): array
    {
        do {
            $businessId = 'BUS-' . strtoupper(Str::random(8));
        } while (BusinessSetup::allBusinesses()->where('business_id', $businessId)->exists());

        return CurrentBusiness::run($businessId, fn () => DB::transaction(function () use ($businessId, $data, $trial) {
            BusinessSetup::create([
                'business_id'      => $businessId,
                'business_name'    => $data['name'],
                'email'            => $data['owner_email'],
                'phone'            => $data['phone'] ?? null,
                'currency'         => $data['currency'] ?? 'ZAR',
                'timezone'         => ($data['timezone'] ?? null) ?: config('app.timezone', 'UTC'),
                'default_tax_rate' => '0',
                'invoice_prefix'   => 'INV',
                'quote_prefix'     => 'QUO',
            ]);

            (new ExpenseCategorySeeder())->run($businessId);

            $user = User::create([
                'business_id' => $businessId,
                'name'        => $data['owner_name'],
                'email'       => strtolower(trim($data['owner_email'])),
                'phone'       => $data['phone'] ?? null,
                'password'    => Hash::make($data['password']),
                'role'        => 'Admin',
                'is_active'   => true,
            ]);

            $subscription = $trial
                ? Subscription::startTrial($businessId, $trial['plan'], $trial['interval'])
                : Subscription::create([
                    'business_id'   => $businessId,
                    'plan'          => 'business',
                    'interval'      => 'monthly',
                    'status'        => 'active',
                    'complimentary' => true,
                ]);

            return ['business_id' => $businessId, 'user' => $user, 'subscription' => $subscription];
        }));
    }
}
