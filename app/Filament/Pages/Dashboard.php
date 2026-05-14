<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BusinessActionWidget;
use App\Filament\Widgets\CrmStatsOverview;
use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\UpcomingJobsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'md'      => 2,
            'xl'      => 3,
        ];
    }

    public function getWidgets(): array
    {
        return [
            CrmStatsOverview::class,      // sort 1 — full width, 4 KPI cards
            BusinessActionWidget::class,  // sort 2 — span 2 (priority actions)
            UpcomingJobsWidget::class,    // sort 3 — span 1 (today's focus, same row as above)
            RevenueChartWidget::class,    // sort 4 — full width chart
        ];
    }
}
