<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'payment_id', 'invoice_id', 'quote_id', 'client_id',
        'amount', 'type', 'method', 'reference', 'notes',
        'received_at', 'recorded_by',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'received_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->payment_id)) {
                $model->payment_id = 'PAY-' . strtoupper(substr(uniqid(), -6));
            }
        });

        // After a payment is saved, recalculate the linked invoice balance
        static::saved(function (self $model) {
            if ($model->invoice_id) {
                $invoice = Invoice::where('invoice_id', $model->invoice_id)->first();
                $invoice?->recalculateBalance();
            }
        });

        static::deleted(function (self $model) {
            if ($model->invoice_id) {
                $invoice = Invoice::where('invoice_id', $model->invoice_id)->first();
                $invoice?->recalculateBalance();
            }
        });
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'invoice_id');
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'quote_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(BusinessClient::class, 'client_id', 'client_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function methodLabel(): string
    {
        return match($this->method) {
            'eft'    => 'EFT',
            'cash'   => 'Cash',
            'card'   => 'Card',
            'paypal' => 'PayPal',
            default  => ucfirst($this->method),
        };
    }
}
