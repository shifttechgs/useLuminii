<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessService;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id', 'service_id', 'description', 'quantity', 'unit_price',
        'tax_rate', 'line_total', 'sort_order',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'tax_rate'   => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            // When a service is selected but description wasn't dehydrated (hidden field), fill it from the service
            if (empty($model->description) && !empty($model->service_id)) {
                $svc = BusinessService::where('service_id', $model->service_id)->first();
                $model->description = $svc?->name ?? 'Service';
            }
        });

        static::saving(function (self $model) {
            $model->line_total = $model->quantity * $model->unit_price;
        });
    }
}

