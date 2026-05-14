<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Job;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\ClientRequest;
use Filament\Widgets\Widget;

class BusinessActionWidget extends Widget
{
    protected static ?int $sort = 2;
    protected static string $view = 'filament.widgets.business-action';
    protected int | string | array $columnSpan = 2;
    protected static bool $isLazy = false;

    protected function getViewData(): array
    {
        $items = [];

        $overdueCount = Invoice::where('status', 'Overdue')->count();
        $overdueValue = Invoice::where('status', 'Overdue')->sum('balance');
        if ($overdueCount > 0) {
            $items[] = [
                'level'  => 'danger',
                'icon'   => 'heroicon-o-exclamation-circle',
                'title'  => $overdueCount === 1 ? '1 overdue invoice' : "{$overdueCount} overdue invoices",
                'detail' => 'R ' . number_format($overdueValue, 2) . ' outstanding — follow up today',
                'url'    => '/useluminii/invoices',
                'cta'    => 'View Invoices',
            ];
        }

        $staleLeads = Lead::whereIn('status', ['New', 'Contacted'])
            ->where('updated_at', '<', now()->subDays(3))
            ->count();
        if ($staleLeads > 0) {
            $items[] = [
                'level'  => 'danger',
                'icon'   => 'heroicon-o-user-group',
                'title'  => $staleLeads === 1 ? '1 lead going cold' : "{$staleLeads} leads going cold",
                'detail' => 'No activity in 3+ days — reach out before they move on',
                'url'    => '/useluminii/leads',
                'cta'    => 'View Leads',
            ];
        }

        $expiringQuotes = Quote::where('status', 'Sent')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(7))
            ->where('expiry_date', '>=', now())
            ->count();
        if ($expiringQuotes > 0) {
            $items[] = [
                'level'  => 'warning',
                'icon'   => 'heroicon-o-clock',
                'title'  => $expiringQuotes === 1 ? '1 quote expiring this week' : "{$expiringQuotes} quotes expiring this week",
                'detail' => 'Follow up before the client loses interest',
                'url'    => '/useluminii/quotes',
                'cta'    => 'View Quotes',
            ];
        }

        $acceptedNoJob = Quote::where('status', 'Accepted')
            ->whereDoesntHave('job')
            ->count();
        if ($acceptedNoJob > 0) {
            $items[] = [
                'level'  => 'warning',
                'icon'   => 'heroicon-o-document-check',
                'title'  => $acceptedNoJob === 1 ? '1 accepted quote not yet converted' : "{$acceptedNoJob} accepted quotes not converted",
                'detail' => 'Confirm deposit and create the job',
                'url'    => '/useluminii/quotes',
                'cta'    => 'View Quotes',
            ];
        }

        $uninvoicedJobs = Job::where('job_status', 'Completed')
            ->whereDoesntHave('invoice')
            ->count();
        if ($uninvoicedJobs > 0) {
            $items[] = [
                'level'  => 'warning',
                'icon'   => 'heroicon-o-receipt-percent',
                'title'  => $uninvoicedJobs === 1 ? '1 completed job not yet invoiced' : "{$uninvoicedJobs} completed jobs not invoiced",
                'detail' => 'Work is done — send the invoice and get paid',
                'url'    => '/useluminii/jobs',
                'cta'    => 'View Jobs',
            ];
        }

        $unscheduledJobs = Job::where('job_status', 'New')
            ->whereNull('job_date_time')
            ->count();
        if ($unscheduledJobs > 0) {
            $items[] = [
                'level'  => 'info',
                'icon'   => 'heroicon-o-calendar-days',
                'title'  => $unscheduledJobs === 1 ? '1 job needs scheduling' : "{$unscheduledJobs} jobs need scheduling",
                'detail' => 'Set a kick-off date so the client knows when to expect progress',
                'url'    => '/useluminii/jobs',
                'cta'    => 'View Jobs',
            ];
        }

        $newRequests = ClientRequest::where('status', 'New')->count();
        if ($newRequests > 0) {
            $items[] = [
                'level'  => 'info',
                'icon'   => 'heroicon-o-inbox',
                'title'  => $newRequests === 1 ? '1 new client request' : "{$newRequests} new client requests",
                'detail' => 'Review and qualify — each one is a potential project',
                'url'    => '/useluminii/pipeline',
                'cta'    => 'Open Pipeline',
            ];
        }

        return ['priorities' => $items];
    }
}
