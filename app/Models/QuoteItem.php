<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id', 'service_id', 'description', 'quantity', 'unit_price',
        'tax_rate', 'line_total', 'sort_order',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'tax_rate'   => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->line_total = $model->quantity * $model->unit_price;
        });
    }
}

