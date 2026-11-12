<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
    use \App\Models\Concerns\BelongsToBusiness;

    protected $fillable = ['business_id', 'name', 'color', 'sort_order'];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'category_id');
    }
}


