<?php

namespace App\Console\Commands;

use App\Models\Quote;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class ExpireQuotes extends Command
{
    protected $signature   = 'crm:expire-quotes';
    protected $description = 'Auto-expire sent quotes past their expiry date and warn about quotes expiring within 2 days';

    /** Runs once per business, so notifications and new records belong to that business. */
    public function handle(): void
    {
        $businessIds = \App\Models\Quote::allBusinesses()->whereNotNull('business_id')->distinct()->pluck('business_id');

        foreach ($businessIds as $businessId) {
            \App\Support\CurrentBusiness::run($businessId, fn () => $this->runForBusiness());
        }
    }

    private function runForBusiness(): void
    {
        $this->expireOverdue();
        $this->warnExpiringSoon();
    }

    private function expireOverdue(): void
    {
        $quotes = Quote::where('status', 'Sent')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<', today())
            ->with('client')
            ->get();

        foreach ($quotes as $quote) {
            // Updating via the model triggers the booted() observer (handleExpired)
            $quote->update(['status' => 'Expired']);
            $this->info("Expired: {$quote->quote_id}");
        }

        if ($quotes->count() > 0) {
            $this->info("Total expired: {$quotes->count()}");
        } else {
            $this->info('No quotes to expire.');
        }
    }

    private function warnExpiringSoon(): void
    {
        $quotes = Quote::where('status', 'Sent')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>', today())
            ->whereDate('expiry_date', '<=', today()->addDays(2))
            ->with('client')
            ->get();

        if ($quotes->isEmpty()) return;

        $list = $quotes->map(fn ($q) => "{$q->quote_id} (" . optional($q->client)->company . ')'
        )->join(', ');

        NotificationService::warning(
            "{$quotes->count()} quote(s) expiring within 2 days",
            $list . ' — follow up now to avoid losing the deal.',
            '/useluminii/quotes'
        );

        $this->info("Expiry warnings sent for: {$list}");
    }
}
