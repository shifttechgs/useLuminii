<?php

namespace App\Models;

use App\Models\ActivityLog;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RecurringInvoice;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_id', 'business_id', 'job_id', 'client_id', 'sales_person_id',
        'created_by', 'invoice_date', 'due_date', 'sub_total', 'total_tax',
        'total_amount', 'discount', 'deposit_paid', 'balance', 'payment_due',
        'internal_notes', 'client_message', 'status', 'currency', 'payment_method',
        'paid_at', 'payment_reference', 'view_token',
        'paypal_order_id', 'paypal_capture_id',
        'invoice_type', 'recurring_invoice_id',
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date'     => 'datetime',
        'paid_at'      => 'datetime',
        'total_amount' => 'decimal:2',
        'balance'      => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->invoice_id)) {
                $model->invoice_id = 'INV-' . strtoupper(substr(uniqid(), -6));
            }
            if (empty($model->view_token)) {
                $model->view_token = \Illuminate\Support\Str::uuid();
            }
            $model->discount      = $model->discount      ?? 0;
            $model->deposit_paid  = $model->deposit_paid  ?? 0;
            $model->sub_total     = $model->sub_total     ?? 0;
            $model->total_amount  = $model->total_amount  ?? 0;
            $model->balance       = $model->balance       ?? 0;
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessClient::class, 'client_id', 'client_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function salesPerson(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_person_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'invoice_id')->orderBy('sort_order');
    }

    public function recurringSchedule(): BelongsTo
    {
        return $this->belongsTo(RecurringInvoice::class, 'recurring_invoice_id', 'recurring_invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id', 'invoice_id')->orderBy('received_at');
    }

    public function recalculateTotals(): void
    {
        $subTotal = $this->items->sum('line_total');
        $this->sub_total    = $subTotal;
        $this->total_tax    = 0;
        $this->total_amount = $subTotal - ($this->discount ?? 0);
        $this->balance      = $this->total_amount - ($this->deposit_paid ?? 0);
        $this->save();
    }

    public function recalculateBalance(): void
    {
        $totalPaid = $this->payments()->sum('amount') + ($this->deposit_paid ?? 0);
        $balance   = max(0, $this->total_amount - $totalPaid);
        $status    = $balance <= 0 ? 'Paid' : ($totalPaid > 0 ? 'PartiallyPaid' : $this->status);
        $this->update([
            'balance' => $balance,
            'status'  => $status,
            'paid_at' => $balance <= 0 && !$this->paid_at ? now() : $this->paid_at,
        ]);
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !in_array($this->status, ['Paid', 'Cancelled']);
    }

    public static function autoCreateFromJob(Job $job): self
    {
        if (static::where('job_id', $job->job_id)->exists()) {
            return static::where('job_id', $job->job_id)->first();
        }

        $job->loadMissing(['items', 'quote', 'client']);

        $subTotal = $job->items->sum('line_total');
        $discount = 0;
        $total    = $subTotal - $discount;

        // Apply deposit from quote if one was received
        $depositPaid = 0;
        if ($job->quote && $job->quote->deposit_received && $job->quote->required_deposit > 0) {
            $depositPaid = $job->quote->required_deposit;
        }
        $balance = max(0, $total - $depositPaid);

        $invoice = self::create([
            'business_id'    => $job->business_id ?? null,
            'job_id'         => $job->job_id,
            'client_id'      => $job->client_id,
            'invoice_type'   => 'project',
            'invoice_date'   => now(),
            'due_date'       => now()->addDays(14),
            'sub_total'      => $subTotal,
            'total_tax'      => 0,
            'total_amount'   => $total,
            'discount'       => $discount,
            'deposit_paid'   => $depositPaid,
            'balance'        => $balance,
            'status'         => 'Draft',
            'internal_notes' => "Auto-generated when job {$job->job_id} was marked complete." .
                                ($depositPaid > 0 ? " Deposit of R " . number_format($depositPaid, 2) . " applied." : ''),
        ]);

        // Copy job items to invoice items
        foreach ($job->items as $item) {
            $invoice->items()->create([
                'description' => $item->description,
                'quantity'    => $item->quantity,
                'unit_price'  => $item->unit_price,
                'line_total'  => $item->line_total,
                'sort_order'  => $item->sort_order ?? 0,
            ]);
        }

        ActivityLog::record('created', 'Invoice', $invoice->invoice_id,
            "Draft invoice auto-created from completed job {$job->job_id}" .
            ($depositPaid > 0 ? " — deposit R " . number_format($depositPaid, 2) . " credited" : ''));

        NotificationService::info(
            "Invoice Draft Ready — {$job->job_id}",
            "Review {$invoice->invoice_id} and send to " .
                (optional($job->client)->company ?: trim(optional($job->client)->firstname . ' ' . optional($job->client)->lastname)),
            '/useluminii/invoices/' . $invoice->invoice_id
        );

        return $invoice;
    }
}



