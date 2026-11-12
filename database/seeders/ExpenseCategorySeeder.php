<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategorySeeder extends Seeder
{
    /** Default categories every business starts with (also used by crm:create-business). */
    public static function defaults(): array
    {
        return [
            ['name' => 'Advertising & Marketing', 'color' => '#6366f1', 'sort_order' => 1],
            ['name' => 'Equipment & Tools',        'color' => '#3b82f6', 'sort_order' => 2],
            ['name' => 'Software & Subscriptions', 'color' => '#8b5cf6', 'sort_order' => 3],
            ['name' => 'Vehicle & Travel',          'color' => '#f59e0b', 'sort_order' => 4],
            ['name' => 'Office Supplies',            'color' => '#10b981', 'sort_order' => 5],
            ['name' => 'Salaries & Wages',           'color' => '#14b8a6', 'sort_order' => 6],
            ['name' => 'Rent & Utilities',           'color' => '#64748b', 'sort_order' => 7],
            ['name' => 'Insurance',                  'color' => '#0ea5e9', 'sort_order' => 8],
            ['name' => 'Professional Fees',          'color' => '#a855f7', 'sort_order' => 9],
            ['name' => 'Bank & Finance Charges',     'color' => '#f43f5e', 'sort_order' => 10],
            ['name' => 'Repairs & Maintenance',      'color' => '#ef4444', 'sort_order' => 11],
            ['name' => 'Miscellaneous',              'color' => '#94a3b8', 'sort_order' => 12],
        ];
    }

    /** Seeds the defaults for one business (the platform business unless given). */
    public function run(?string $businessId = null): void
    {
        $businessId ??= config('crm.business_id', 'ST-001');

        foreach (self::defaults() as $cat) {
            DB::table('expense_categories')->updateOrInsert(
                ['business_id' => $businessId, 'name' => $cat['name']],
                array_merge($cat, ['business_id' => $businessId, 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}

