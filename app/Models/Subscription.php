<?php

namespace App\Models;

use App\Support\CurrentBusiness;
use Illuminate\Database\Eloquent\Model;

/**
 * A business's useLuminii subscription: its plan, trial and billing state.
 * Prices, seats and features come from config/plans.php.
 *
 * Status:
 *   trialing   14-day trial on Business features, no card
 *   active     paid up (or complimentary)
 *   past_due   a renewal payment failed; still usable during the grace period
 *   read_only  trial ended or grace period over: can read, can't change anything
 *   cancelled  cancelled at the end of a paid period: read-only, data kept
 */
class Subscription extends Model
{
    use \App\Models\Concerns\BelongsToBusiness;

    public const STATUSES = ['trialing', 'active', 'past_due', 'read_only', 'cancelled'];

    protected $fillable = [
        'business_id', 'plan', 'interval', 'status', 'complimentary',
        'trial_ends_at', 'current_period_end', 'extra_seats', 'cancel_at_period_end', 'pending_changes',
        'paystack_customer_code', 'authorization_code', 'card_brand', 'card_last4', 'card_exp',
    ];

    protected $hidden = ['authorization_code'];

    protected $casts = [
        'complimentary'        => 'boolean',
        'trial_ends_at'        => 'datetime',
        'current_period_end'   => 'datetime',
        'extra_seats'          => 'integer',
        'cancel_at_period_end' => 'boolean',
        'pending_changes'      => 'array',
        'authorization_code'   => 'encrypted',
    ];

    /** The current business's subscription, or null (e.g. guests, or businesses not set up yet). */
    public static function current(): ?self
    {
        $businessId = CurrentBusiness::id();
        if ($businessId === null || $businessId === CurrentBusiness::NONE) {
            return null;
        }

        try {
            return static::where('business_id', $businessId)->first();
        } catch (\Illuminate\Database\QueryException $e) {
            // Deployed before the subscriptions migration ran: don't limit anyone.
            report($e);

            return null;
        }
    }

    public static function startTrial(string $businessId, string $chosenPlan, string $interval): self
    {
        return static::create([
            'business_id'   => $businessId,
            'plan'          => array_key_exists($chosenPlan, config('plans.plans')) ? $chosenPlan : config('plans.trial_plan'),
            'interval'      => $interval === 'annual' ? 'annual' : 'monthly',
            'status'        => 'trialing',
            'trial_ends_at' => now()->addDays((int) config('plans.trial_days', 14)),
        ]);
    }

    // ── State ──

    public function onTrial(): bool
    {
        return $this->status === 'trialing' && $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /** Can read but not change anything: trial over, grace period over, or cancelled. */
    public function isReadOnly(): bool
    {
        if (in_array($this->status, ['read_only', 'cancelled'], true)) {
            return true;
        }

        // A trial that has run out is read-only straight away, even before the daily job marks it.
        return $this->status === 'trialing' && (! $this->trial_ends_at || $this->trial_ends_at->isPast());
    }

    public function trialDaysLeft(): int
    {
        if (! $this->trial_ends_at || $this->trial_ends_at->isPast()) {
            return 0;
        }

        return max(1, (int) ceil(now()->diffInHours($this->trial_ends_at) / 24));
    }

    // ── Plan ──

    /** The plan whose features apply now: trials get the trial plan's features. */
    public function effectivePlan(): string
    {
        return $this->status === 'trialing' ? config('plans.trial_plan', 'business') : $this->plan;
    }

    public function planConfig(?string $plan = null): array
    {
        return config('plans.plans.' . ($plan ?? $this->plan), []);
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, config('plans.plans.' . $this->effectivePlan() . '.features', []), true);
    }

    /** Users the business may have now (trials get the trial plan's seats). */
    public function seatLimit(): int
    {
        $plan = config('plans.plans.' . $this->effectivePlan(), []);
        $extra = ($plan['extra_user'] ?? null) ? $this->extra_seats : 0;

        return (int) ($plan['users'] ?? 1) + $extra;
    }

    public function seatsUsed(): int
    {
        return User::allBusinesses()
            ->where('business_id', $this->business_id)
            ->where('is_active', true)
            ->count();
    }

    public function hasFreeSeat(): bool
    {
        return $this->complimentary || $this->seatsUsed() < $this->seatLimit();
    }
}
