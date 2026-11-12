<?php

namespace App\Support;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

/**
 * Validation rules that respect per-business separation.
 */
class BusinessRules
{
    /**
     * Like "exists:table,column", but only finds rows of the current business, so a form
     * can't link a record to another business's client, job, user or category.
     */
    public static function exists(string $table, string $column = 'id'): Exists
    {
        return Rule::exists($table, $column)->where(function ($query) {
            $businessId = CurrentBusiness::id();
            if ($businessId !== null) {
                $query->where('business_id', $businessId);
            }
        });
    }
}
