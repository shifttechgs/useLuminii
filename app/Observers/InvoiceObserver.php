<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\ActivityLog;
use App\Services\NotificationService;

class InvoiceObserver
{
    public function created(Invoice $invoice): void
    {
        ActivityLog::record('created', 'Invoice', $invoice->invoice_id,
            "Invoice {$invoice->invoice_id} created for client #{$invoice->client_id} — R " . number_format($invoice->total_amount, 2));

        NotificationService::success(
            "Invoice Created: {$invoice->invoice_id}",
            "R " . number_format($invoice->total_amount, 2) . " — " . $invoice->status,
            '/useluminii/invoices'
        );
    }

    public function updated(Invoice $invoice): void
    {
        if ($invoice->isDirty('status')) {
            $old = $invoice->getOriginal('status');
            $new = $invoice->status;

            ActivityLog::record('updated', 'Invoice', $invoice->invoice_id,
                "Invoice {$invoice->invoice_id} status changed: {$old} → {$new}");

            if ($new === 'Paid') {
                NotificationService::success(
                    "Invoice Paid! 🎉 {$invoice->invoice_id}",
                    "R " . number_format($invoice->total_amount, 2) . " received",
                    '/useluminii/invoices'
                );
            } elseif ($new === 'Overdue') {
                NotificationService::danger(
                    "Invoice Overdue: {$invoice->invoice_id}",
                    "R " . number_format($invoice->balance ?? $invoice->total_amount, 2) . " outstanding",
                    '/useluminii/invoices'
                );
            }
        }
    }
}

