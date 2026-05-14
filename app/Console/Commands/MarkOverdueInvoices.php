<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class MarkOverdueInvoices extends Command
{
    protected $signature   = 'crm:overdue-invoices';
    protected $description = 'Mark invoices past due date as Overdue and create notifications';

    public function handle(): void
    {
        $invoices = Invoice::whereIn('status', ['Sent', 'PartiallyPaid'])
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', today())
            ->get();

        foreach ($invoices as $invoice) {
            $invoice->update(['status' => 'Overdue']);
            $this->info("Marked overdue: {$invoice->invoice_id}");
        }

        if ($invoices->count() > 0) {
            NotificationService::danger(
                "{$invoices->count()} invoice(s) are now overdue",
                'Visit the invoices section to follow up.',
                '/useluminii/invoices'
            );
        }

        $this->info("Done. {$invoices->count()} invoice(s) marked overdue.");
    }
}

