<?php

namespace App\Observers;

use App\Models\Quote;
use App\Models\ActivityLog;
use App\Services\NotificationService;

class QuoteObserver
{
    public function created(Quote $quote): void
    {
        ActivityLog::record('created', 'Quote', $quote->quote_id,
            "Quote {$quote->quote_id} created — R " . number_format($quote->grand_total ?? 0, 2));

        NotificationService::info(
            "New Quote: {$quote->quote_id}",
            "R " . number_format($quote->grand_total ?? 0, 2),
            '/useluminii/quotes'
        );
    }

    public function updated(Quote $quote): void
    {
        if ($quote->isDirty('status')) {
            $old = $quote->getOriginal('status');
            $new = $quote->status;

            ActivityLog::record('updated', 'Quote', $quote->quote_id,
                "Quote {$quote->quote_id} status changed: {$old} → {$new}");

            if ($new === 'Accepted') {
                NotificationService::success(
                    "Quote Accepted! ✅ {$quote->quote_id}",
                    "Client accepted quote worth R " . number_format($quote->grand_total ?? 0, 2),
                    '/useluminii/quotes'
                );
            } elseif ($new === 'Declined') {
                NotificationService::warning(
                    "Quote Declined: {$quote->quote_id}",
                    "Consider following up with the client.",
                    '/useluminii/quotes'
                );
            }
        }
    }
}

