<?php

namespace App\Filament\Pages;

use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Job;
use App\Models\BusinessClient;
use App\Models\Quote;
use App\Models\Lead;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?string $navigationLabel = 'Reports & Analytics';
    protected static ?string $title           = 'Reports & Analytics';
    protected static ?int    $navigationSort  = 1;
    protected static string  $view            = 'filament.pages.reports';

    // Filter state
    public ?string $date_from  = null;
    public ?string $date_to    = null;
    public string  $period     = 'this_month';

    public function mount(): void
    {
        $this->applyPeriod();
        $this->form->fill([
            'period'    => $this->period,
            'date_from' => $this->date_from,
            'date_to'   => $this->date_to,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('period')
                    ->label('Quick Period')
                    ->options([
                        'today'        => 'Today',
                        'this_week'    => 'This Week',
                        'this_month'   => 'This Month',
                        'last_month'   => 'Last Month',
                        'this_quarter' => 'This Quarter',
                        'this_year'    => 'This Year',
                        'custom'       => 'Custom Range',
                    ])
                    ->default('this_month')
                    ->live()
                    ->afterStateUpdated(fn () => $this->applyPeriod()),

                DatePicker::make('date_from')
                    ->label('From')
                    ->visible(fn () => $this->period === 'custom')
                    ->live()
                    ->afterStateUpdated(fn ($state) => $this->date_from = $state),

                DatePicker::make('date_to')
                    ->label('To')
                    ->visible(fn () => $this->period === 'custom')
                    ->live()
                    ->afterStateUpdated(fn ($state) => $this->date_to = $state),
            ])
            ->columns(3)
            ->statePath('');
    }

    protected function applyPeriod(): void
    {
        $now = Carbon::now();

        match ($this->period) {
            'today'        => [$this->date_from, $this->date_to] = [$now->toDateString(), $now->toDateString()],
            'this_week'    => [$this->date_from, $this->date_to] = [$now->startOfWeek()->toDateString(), $now->copy()->endOfWeek()->toDateString()],
            'this_month'   => [$this->date_from, $this->date_to] = [$now->copy()->startOfMonth()->toDateString(), $now->copy()->endOfMonth()->toDateString()],
            'last_month'   => [$this->date_from, $this->date_to] = [$now->copy()->subMonth()->startOfMonth()->toDateString(), $now->copy()->subMonth()->endOfMonth()->toDateString()],
            'this_quarter' => [$this->date_from, $this->date_to] = [$now->copy()->startOfQuarter()->toDateString(), $now->copy()->endOfQuarter()->toDateString()],
            'this_year'    => [$this->date_from, $this->date_to] = [$now->copy()->startOfYear()->toDateString(), $now->copy()->endOfYear()->toDateString()],
            default        => null,
        };
    }

    // ── Summary Cards ─────────────────────────────────────────────────────────

    public function getSummaryStats(): array
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        $revenue       = Invoice::where('status', 'Paid')->whereBetween('paid_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->sum('total_amount');
        $pending       = Invoice::whereIn('status', ['Sent', 'PartiallyPaid'])->whereBetween('invoice_date', [$from, $to])->sum('balance');
        $overdue       = Invoice::where('status', 'Overdue')->whereBetween('invoice_date', [$from, $to])->sum('balance');
        $expenses      = Expense::whereBetween('expense_date', [$from, $to])->sum('amount');
        $profit        = $revenue - $expenses;
        $jobsCompleted = Job::where('job_status', 'Completed')->whereBetween('updated_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->count();
        $newClients    = BusinessClient::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->count();
        $quotesAccepted= Quote::where('status', 'Accepted')->whereBetween('updated_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->count();
        $quotesTotal   = Quote::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->count();
        $conversionRate= $quotesTotal > 0 ? round(($quotesAccepted / $quotesTotal) * 100, 1) : 0;

        return compact('revenue','pending','overdue','expenses','profit','jobsCompleted','newClients','quotesAccepted','conversionRate');
    }

    // ── Revenue Chart (monthly breakdown) ────────────────────────────────────

    public function getRevenueChartData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        return [
            'labels' => $months->map(fn ($m) => $m->format('M Y'))->toArray(),
            'revenue' => $months->map(fn ($m) =>
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

    // ── Top Clients by Revenue ────────────────────────────────────────────────

    public function getTopClients(): \Illuminate\Support\Collection
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        return Invoice::with('client')
            ->where('status', 'Paid')
            ->whereBetween('paid_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select('client_id', DB::raw('SUM(total_amount) as total_revenue'), DB::raw('COUNT(*) as invoice_count'))
            ->groupBy('client_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();
    }

    // ── Jobs Breakdown ────────────────────────────────────────────────────────

    public function getJobsBreakdown(): array
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        return Job::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select('job_status', DB::raw('COUNT(*) as count'))
            ->groupBy('job_status')
            ->pluck('count', 'job_status')
            ->toArray();
    }

    // ── Expense Breakdown by Category ────────────────────────────────────────

    public function getExpenseBreakdown(): \Illuminate\Support\Collection
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        return Expense::with('category')
            ->whereBetween('expense_date', [$from, $to])
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();
    }

    // ── Lead Source Breakdown ────────────────────────────────────────────────

    public function getLeadSourceBreakdown(): \Illuminate\Support\Collection
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        return BusinessClient::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select('lead_source', DB::raw('COUNT(*) as count'))
            ->groupBy('lead_source')
            ->orderByDesc('count')
            ->get();
    }

    // ── Invoice Status Breakdown ──────────────────────────────────────────────

    public function getInvoiceBreakdown(): array
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        return Invoice::whereBetween('invoice_date', [$from, $to])
            ->select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('status')
            ->get()
            ->keyBy('status')
            ->toArray();
    }

    // ── CSV Exports ───────────────────────────────────────────────────────────

    public function exportInvoices(): StreamedResponse
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        $invoices = Invoice::with('client')
            ->whereBetween('invoice_date', [$from, $to])
            ->orderBy('invoice_date', 'desc')
            ->get();

        return response()->streamDownload(function () use ($invoices) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Invoice #', 'Client', 'Status', 'Date', 'Due Date', 'Total', 'Balance', 'Paid At']);
            foreach ($invoices as $inv) {
                fputcsv($handle, [
                    $inv->invoice_id,
                    optional($inv->client)->firstname . ' ' . optional($inv->client)->lastname,
                    $inv->status,
                    $inv->invoice_date?->format('Y-m-d'),
                    $inv->due_date?->format('Y-m-d'),
                    $inv->total_amount,
                    $inv->balance,
                    $inv->paid_at?->format('Y-m-d'),
                ]);
            }
            fclose($handle);
        }, "invoices_{$from}_to_{$to}.csv", ['Content-Type' => 'text/csv']);
    }

    public function exportExpenses(): StreamedResponse
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        $expenses = Expense::with('category')
            ->whereBetween('expense_date', [$from, $to])
            ->orderBy('expense_date', 'desc')
            ->get();

        return response()->streamDownload(function () use ($expenses) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Expense ID', 'Description', 'Vendor', 'Category', 'Amount', 'Date', 'Recurring']);
            foreach ($expenses as $exp) {
                fputcsv($handle, [
                    $exp->expense_id,
                    $exp->description,
                    $exp->vendor,
                    optional($exp->category)->name,
                    $exp->amount,
                    $exp->expense_date?->format('Y-m-d'),
                    $exp->is_recurring ? 'Yes' : 'No',
                ]);
            }
            fclose($handle);
        }, "expenses_{$from}_to_{$to}.csv", ['Content-Type' => 'text/csv']);
    }

    public function exportJobs(): StreamedResponse
    {
        $from = $this->date_from;
        $to   = $this->date_to;

        $jobs = Job::with('client')
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->orderBy('job_date_time', 'desc')
            ->get();

        return response()->streamDownload(function () use ($jobs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Job #', 'Title', 'Client', 'Status', 'Scheduled', 'Assigned', 'Date']);
            foreach ($jobs as $job) {
                fputcsv($handle, [
                    $job->job_id,
                    $job->job_title,
                    optional($job->client)->firstname . ' ' . optional($job->client)->lastname,
                    $job->job_status,
                    $job->scheduled_status,
                    $job->assigned_status,
                    $job->job_date_time?->format('Y-m-d'),
                ]);
            }
            fclose($handle);
        }, "jobs_{$from}_to_{$to}.csv", ['Content-Type' => 'text/csv']);
    }
}

