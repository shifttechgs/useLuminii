<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recurring_invoice_id', 'business_id', 'client_id', 'job_id',
        'frequency', 'total_amount', 'balance', 'deposit_paid', 'payment_due',
        'status', 'internal_notes', 'client_message', 'created_by',
        'start_date', 'end_date', 'next_invoice_date', 'invoices_generated',
    ];

    protected $casts = [
        'start_date'          => 'date',
        'end_date'            => 'date',
        'next_invoice_date'   => 'date',
        'total_amount'        => 'decimal:2',
        'balance'             => 'decimal:2',
        'deposit_paid'        => 'decimal:2',
        'payment_due'         => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $m) {
            if (empty($m->recurring_invoice_id)) {
                $m->recurring_invoice_id = 'REC-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessClient::class, 'client_id', 'client_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RecurringInvoiceItem::class);
    }
}

