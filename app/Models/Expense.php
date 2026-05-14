<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'expense_id', 'business_id', 'user_id', 'category_id',
        'description', 'vendor', 'amount', 'expense_date',
        'is_recurring', 'recurrence_type', 'notes', 'receipt_path',
    ];

    protected $casts = [
        'expense_date' => 'datetime',
        'is_recurring' => 'boolean',
        'amount'       => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->expense_id)) {
                $model->expense_id = 'EXP-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

