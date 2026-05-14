<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\ClientRequest;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\ScheduledJob;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();

        $stats = Cache::remember('crm_dashboard_stats', 60, function () use ($now) {
            $monthStart = $now->copy()->startOfMonth();
            $monthEnd   = $now->copy()->endOfMonth();
            $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
            $lastMonthEnd   = $now->copy()->subMonth()->endOfMonth();

            $revenueThisMonth = Invoice::where('status', 'Paid')
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->sum('total_amount');
            $revenueLastMonth = Invoice::where('status', 'Paid')
                ->whereBetween('paid_at', [$lastMonthStart, $lastMonthEnd])
                ->sum('total_amount');

            $clientsThisMonth = BusinessClient::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $clientsLastMonth = BusinessClient::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

            $jobsThisMonth = Job::where('job_status', 'Completed')
                ->whereBetween('updated_at', [$monthStart, $monthEnd])->count();
            $jobsLastMonth = Job::where('job_status', 'Completed')
                ->whereBetween('updated_at', [$lastMonthStart, $lastMonthEnd])->count();

            return [
                'total_clients'     => BusinessClient::count(),
                'leads'             => BusinessClient::where('client_type', 'Lead')->count(),
                'active_jobs'       => Job::whereIn('job_status', ['New', 'InProgress'])->count(),
                'completed_month'   => $jobsThisMonth,
                'completed_last'    => $jobsLastMonth,
                'revenue_paid'      => $revenueThisMonth,
                'revenue_last'      => $revenueLastMonth,
                'revenue_pending'   => Invoice::whereIn('status', ['Sent', 'PartiallyPaid'])->sum('balance'),
                'overdue_count'     => Invoice::where('status', 'Overdue')->count(),
                'overdue_value'     => Invoice::where('status', 'Overdue')->sum('balance'),
                'open_quotes'       => Quote::whereIn('status', ['Draft', 'Sent'])->count(),
                'open_quotes_value' => Quote::whereIn('status', ['Draft', 'Sent'])->sum('grand_total'),
                'new_clients_month' => $clientsThisMonth,
                'new_clients_last'  => $clientsLastMonth,
                'open_requests'     => class_exists(ClientRequest::class) ? ClientRequest::whereIn('status', ['New', 'InReview'])->count() : 0,
                'website_leads'     => Lead::where('status', 'New')->count(),
            ];
        });

        $revenueChart = Cache::remember('crm_revenue_chart', 300, function () {
            $months = [];
            for ($i = 5; $i >= 0; $i--) {
                $date  = now()->subMonths($i);
                $label = $date->format('M');
                $start = $date->copy()->startOfMonth();
                $end   = $date->copy()->endOfMonth();

                $months[] = [
                    'label'    => $label,
                    'revenue'  => Invoice::where('status', 'Paid')
                        ->whereBetween('paid_at', [$start, $end])
                        ->sum('total_amount'),
                    'expenses' => Expense::whereBetween('expense_date', [$start, $end])
                        ->sum('amount'),
                ];
            }
            return $months;
        });

        $recentActivity = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        $upcomingJobs = Job::with('client')
            ->whereIn('job_status', ['New', 'Scheduled', 'InProgress'])
            ->orderBy('job_date_time', 'asc')
            ->limit(6)
            ->get();

        $overdueInvoices = Invoice::with('client')
            ->where('status', 'Overdue')
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        $recentQuotes = Quote::with('client')
            ->whereIn('status', ['Draft', 'Sent'])
            ->latest()
            ->limit(5)
            ->get();

        $quickServices = BusinessService::where('is_active', true)
            ->orderBy('category')->orderBy('name')->get();
        $quickClients  = BusinessClient::orderBy('company')->orderBy('firstname')->get()
            ->mapWithKeys(fn ($c) => [
                $c->client_id => ($c->company ? "{$c->company} — " : '') . "{$c->firstname} {$c->lastname}"
            ]);
        $quickUsers = User::orderBy('name')->get();

        return view('crm.dashboard.index', compact(
            'stats', 'revenueChart', 'recentActivity', 'upcomingJobs', 'overdueInvoices', 'recentQuotes',
            'quickServices', 'quickClients', 'quickUsers'
        ));
    }
}
