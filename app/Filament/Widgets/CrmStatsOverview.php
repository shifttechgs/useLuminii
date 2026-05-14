<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Job;
use App\Models\Lead;
use App\Models\Quote;
use Filament\Widgets\Widget;

class CrmStatsOverview extends Widget
{
    protected static ?int $sort = 1;
    protected static string $view = 'filament.widgets.crm-stats-overview';
    protected int | string | array $columnSpan = ['md' => 2, 'xl' => 3];
    protected static bool $isLazy = false;

    protected function getViewData(): array
    {
        $monthStart = now()->startOfMonth();
        $lastStart  = now()->subMonth()->startOfMonth();
        $lastEnd    = now()->subMonth()->endOfMonth();

        // KPI 1 — Revenue collected this month
        $collected      = (float) Invoice::where('status', 'Paid')->where('paid_at', '>=', $monthStart)->sum('total_amount');
        $lastCollected  = (float) Invoice::where('status', 'Paid')->whereBetween('paid_at', [$lastStart, $lastEnd])->sum('total_amount');
        $collectedChange = $lastCollected > 0 ? round((($collected - $lastCollected) / $lastCollected) * 100) : null;
        $collectedSpark  = collect(range(13, 0))->map(fn ($d) =>
            (float) Invoice::where('status', 'Paid')->whereDate('paid_at', now()->subDays($d))->sum('total_amount')
        )->values()->toArray();

        // KPI 2 — Outstanding balance
        $outstanding    = (float) Invoice::whereIn('status', ['Sent', 'PartiallyPaid', 'Overdue'])->sum('balance');
        $overdueCount   = Invoice::where('status', 'Overdue')->count();
        $outstandingSpark = collect(range(13, 0))->map(fn ($d) =>
            (float) Invoice::whereDate('invoice_date', now()->subDays($d))->sum('total_amount')
        )->values()->toArray();

        // KPI 3 — New leads this month
        $newLeads       = Lead::where('created_at', '>=', $monthStart)->count();
        $lastLeads      = Lead::whereBetween('created_at', [$lastStart, $lastEnd])->count();
        $leadsChange    = $lastLeads > 0 ? round((($newLeads - $lastLeads) / $lastLeads) * 100) : null;
        $leadsSpark     = collect(range(13, 0))->map(fn ($d) =>
            (float) Lead::whereDate('created_at', now()->subDays($d))->count()
        )->values()->toArray();

        // KPI 4 — Pipeline (open quotes)
        $pipelineValue  = (float) Quote::whereIn('status', ['Sent'])->sum('grand_total');
        $pipelineCount  = Quote::whereIn('status', ['Sent'])->count();
        $lastPipeline   = (float) Quote::whereIn('status', ['Sent', 'Accepted'])->whereBetween('created_at', [$lastStart, $lastEnd])->sum('grand_total');
        $pipelineChange = $lastPipeline > 0 ? round((($pipelineValue - $lastPipeline) / $lastPipeline) * 100) : null;
        $pipelineSpark  = collect(range(13, 0))->map(fn ($d) =>
            (float) Quote::whereDate('created_at', now()->subDays($d))->sum('grand_total')
        )->values()->toArray();

        // KPI 5 — Active jobs
        $activeJobs      = Job::whereIn('job_status', ['InProgress', 'Scheduled'])->count();
        $lastActiveJobs  = Job::whereIn('job_status', ['InProgress', 'Scheduled', 'Completed'])
            ->whereBetween('updated_at', [$lastStart, $lastEnd])->count();
        $activeJobsChange = $lastActiveJobs > 0 ? round((($activeJobs - $lastActiveJobs) / $lastActiveJobs) * 100) : null;
        $completedMonth  = Job::where('job_status', 'Completed')->where('updated_at', '>=', $monthStart)->count();
        $activeJobsSpark = collect(range(13, 0))->map(fn ($d) =>
            (float) Job::whereIn('job_status', ['InProgress', 'Scheduled', 'Completed'])
                ->whereDate('updated_at', now()->subDays($d))->count()
        )->values()->toArray();

        return compact(
            'collected', 'collectedChange', 'collectedSpark',
            'outstanding', 'overdueCount', 'outstandingSpark',
            'newLeads', 'leadsChange', 'leadsSpark',
            'pipelineValue', 'pipelineCount', 'pipelineChange', 'pipelineSpark',
            'activeJobs', 'activeJobsChange', 'completedMonth', 'activeJobsSpark'
        );
    }
}
