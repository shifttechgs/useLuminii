<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Invoice;
use Filament\Widgets\Widget;

class RevenueChartWidget extends Widget
{
    protected static ?int $sort = 4;
    protected static string $view = 'filament.widgets.revenue-chart';
    protected int|string|array $columnSpan = ['md' => 2, 'xl' => 3];
    protected static bool $isLazy = false;

    protected function getViewData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        return [
            'labels'   => $months->map(fn ($m) => $m->format('M Y'))->toArray(),
            'revenue'  => $months->map(fn ($m) =>
                (float) Invoice::where('status', 'Paid')
                    ->whereYear('paid_at', $m->year)
                    ->whereMonth('paid_at', $m->month)
                    ->sum('total_amount')
            )->toArray(),
            'expenses' => $months->map(fn ($m) =>
                (float) Expense::whereYear('expense_date', $m->year)
                    ->whereMonth('expense_date', $m->month)
                    ->sum('amount')
            )->toArray(),
        ];
    }
}
