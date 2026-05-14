<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Models\Job;
use App\Models\RecurringInvoice;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    private array $recurringData = [];

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mount(): void
    {
        parent::mount();

        $jobId = request()->query('job_id');
        if (!$jobId) return;

        $job = Job::with('items', 'quote')->where('job_id', $jobId)->first();
        if (!$job) return;

        $depositPaid = 0;
        if ($job->quote && $job->quote->deposit_received && $job->quote->required_deposit > 0) {
            $depositPaid = $job->quote->required_deposit;
        }

        $this->form->fill([
            'invoice_type' => 'project',
            'job_id'       => $job->job_id,
            'client_id'    => $job->client_id,
            'deposit_paid' => $depositPaid,
            'items'        => $job->items->map(fn ($item) => [
                'service_id'  => $item->service_id ?? null,
                'description' => $item->description,
                'quantity'    => $item->quantity,
                'unit_price'  => $item->unit_price,
                'line_total'  => $item->line_total,
                'sort_order'  => $item->sort_order ?? 0,
            ])->toArray(),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Capture recurring fields before they reach the Invoice model
        $this->recurringData = [
            'is_recurring'    => (bool) ($data['is_recurring'] ?? false),
            'frequency'       => $data['recur_frequency'] ?? 'Monthly',
            'start_date'      => $data['recur_start_date'] ?? today()->toDateString(),
            'end_date'        => $data['recur_end_date'] ?? null,
        ];

        unset($data['is_recurring'], $data['recur_frequency'], $data['recur_start_date'], $data['recur_end_date']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!($this->recurringData['is_recurring'] ?? false)) {
            return;
        }

        $invoice = $this->record;
        $invoice->loadMissing('items');

        $rec = RecurringInvoice::create([
            'client_id'           => $invoice->client_id,
            'job_id'              => $invoice->job_id,
            'frequency'           => $this->recurringData['frequency'],
            'total_amount'        => $invoice->total_amount,
            'deposit_paid'        => $invoice->deposit_paid,
            'payment_due'         => $invoice->balance,
            'status'              => 'Active',
            'client_message'      => $invoice->client_message,
            'internal_notes'      => $invoice->internal_notes,
            'created_by'          => auth()->id(),
            'start_date'          => $this->recurringData['start_date'],
            'end_date'            => $this->recurringData['end_date'],
            'next_invoice_date'   => $this->nextDateFrom($this->recurringData['frequency'], $this->recurringData['start_date']),
            'invoices_generated'  => 1,
        ]);

        foreach ($invoice->items as $item) {
            $rec->items()->create([
                'description' => $item->description,
                'quantity'    => $item->quantity,
                'unit_price'  => $item->unit_price,
                'line_total'  => $item->line_total,
            ]);
        }

        // Link the invoice back to its recurring schedule
        $invoice->update(['recurring_invoice_id' => $rec->recurring_invoice_id]);
    }

    private function nextDateFrom(string $frequency, string $startDate): string
    {
        $date = \Carbon\Carbon::parse($startDate);
        return match ($frequency) {
            'Weekly'    => $date->addWeek()->toDateString(),
            'Quarterly' => $date->addMonths(3)->toDateString(),
            'Annually'  => $date->addYear()->toDateString(),
            default     => $date->addMonth()->toDateString(),
        };
    }
}
