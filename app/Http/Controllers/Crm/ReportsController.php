<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\BusinessClient;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '6months');

        // Revenue vs Expenses — last N months
        $months = [];
        $monthCount = $period === '12months' ? 12 : ($period === '3months' ? 3 : 6);

        for ($i = $monthCount - 1; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $start = $date->copy()->startOfMonth();
            $end   = $date->copy()->endOfMonth();

            $months[] = [
                'label'    => $date->format('M y'),
                'revenue'  => Invoice::where('status', 'Paid')->whereBetween('paid_at', [$start, $end])->sum('total_amount'),
                'expenses' => Expense::whereBetween('expense_date', [$start, $end])->sum('amount'),
                'invoiced' => Invoice::whereNotIn('status', ['Draft', 'Cancelled'])->whereBetween('invoice_date', [$start, $end])->sum('total_amount'),
            ];
        }

        // Top clients by revenue
        $topClients = BusinessClient::withSum(
            ['invoices as paid_total' => fn($q) => $q->where('status', 'Paid')],
            'total_amount'
        )->orderByDesc('paid_total')->limit(10)->get();

        // Invoice status breakdown
        $invoiceBreakdown = [
            'Draft'          => Invoice::where('status', 'Draft')->count(),
            'Sent'           => Invoice::where('status', 'Sent')->count(),
            'PartiallyPaid'  => Invoice::where('status', 'PartiallyPaid')->count(),
            'Paid'           => Invoice::where('status', 'Paid')->count(),
            'Overdue'        => Invoice::where('status', 'Overdue')->count(),
            'Cancelled'      => Invoice::where('status', 'Cancelled')->count(),
        ];

        // Quote conversion
        $quoteStats = [
            'total'    => Quote::count(),
            'accepted' => Quote::where('status', 'Accepted')->count(),
            'declined' => Quote::where('status', 'Declined')->count(),
            'pending'  => Quote::whereIn('status', ['Draft', 'Sent'])->count(),
        ];

        // Job stats
        $jobStats = [
            'total'     => Job::count(),
            'completed' => Job::where('job_status', 'Completed')->count(),
            'active'    => Job::whereIn('job_status', ['New', 'InProgress', 'Scheduled'])->count(),
        ];

        // Summary totals
        $summary = [
            'revenue_total'  => Invoice::where('status', 'Paid')->sum('total_amount'),
            'expenses_total' => Expense::sum('amount'),
            'outstanding'    => Invoice::whereIn('status', ['Sent', 'PartiallyPaid', 'Overdue'])->sum('balance'),
            'overdue_total'  => Invoice::where('status', 'Overdue')->sum('balance'),
        ];
        $summary['profit'] = $summary['revenue_total'] - $summary['expenses_total'];

        // Expense by category
        $expenseByCategory = Expense::join('expense_categories', 'expense_categories.id', '=', 'expenses.category_id')
            ->selectRaw('expense_categories.name, expense_categories.color, SUM(expenses.amount) as total')
            ->groupBy('expense_categories.id', 'expense_categories.name', 'expense_categories.color')
            ->orderByDesc('total')
            ->get();

        return view('crm.reports.index', compact(
            'months', 'topClients', 'invoiceBreakdown', 'quoteStats',
            'jobStats', 'summary', 'expenseByCategory', 'period'
        ));
    }
}

