<x-filament-panels::page>
    @php
        $stats         = $this->getSummaryStats();
        $chart         = $this->getRevenueChartData();
        $topClients    = $this->getTopClients();
        $jobsBreakdown = $this->getJobsBreakdown();
        $expBreakdown  = $this->getExpenseBreakdown();
        $leadSources   = $this->getLeadSourceBreakdown();
        $invBreakdown  = $this->getInvoiceBreakdown();

        $jobColors = [
            'New'        => '#0a1628',
            'Scheduled'  => '#3b82f6',
            'InProgress' => '#f59e0b',
            'Completed'  => '#10b981',
            'Cancelled'  => '#f43f5e',
        ];
    @endphp

    {{-- ── Filters ─────────────────────────────────────────────── --}}
    <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:20px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
        <form wire:submit.prevent>{{ $this->form }}</form>
    </div>

    {{-- ── Summary Cards ────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @php
        $sym = \App\Models\BusinessSetup::currencySymbol();
        $summaryCards = [
            ['label' => 'Revenue',          'value' => $sym . ' ' . number_format($stats['revenue'],  2), 'sub' => $sym . ' ' . number_format($stats['pending'], 2) . ' pending',  'valueColor' => '#10b981'],
            ['label' => 'Expenses',          'value' => $sym . ' ' . number_format($stats['expenses'], 2), 'sub' => 'Period total',                                                   'valueColor' => '#f43f5e'],
            ['label' => 'Net Profit',        'value' => $sym . ' ' . number_format($stats['profit'],   2), 'sub' => 'Revenue − Expenses',                                             'valueColor' => $stats['profit'] >= 0 ? '#10b981' : '#f43f5e'],
            ['label' => 'Jobs Completed',    'value' => $stats['jobsCompleted'],                            'sub' => $stats['newClients'] . ' new clients',                            'valueColor' => '#0d1b2e'],
            ['label' => 'Quote Conversion',  'value' => $stats['conversionRate'] . '%',                    'sub' => $stats['quotesAccepted'] . ' accepted',                            'valueColor' => '#f59e0b'],
            ['label' => 'Overdue Balance',   'value' => $sym . ' ' . number_format($stats['overdue'],  2), 'sub' => 'Needs attention',                                                 'valueColor' => $stats['overdue'] > 0 ? '#f43f5e' : '#8898aa', 'alert' => $stats['overdue'] > 0],
        ];
        @endphp
        @foreach($summaryCards as $card)
        <div style="background:#fff;border-radius:12px;border:1px solid {{ ($card['alert'] ?? false) ? '#fecdd3' : '#e4e9f0' }};padding:18px 20px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
            <p style="font-size:0.6875rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:#8898aa;">{{ $card['label'] }}</p>
            <p style="font-size:1.375rem;font-weight:700;color:{{ $card['valueColor'] }};margin-top:6px;letter-spacing:-0.03em;line-height:1.1;font-variant-numeric:tabular-nums;">{{ $card['value'] }}</p>
            <p style="font-size:0.75rem;color:#8898aa;margin-top:4px;">{{ $card['sub'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── Revenue vs Expenses Chart ────────────────────────────── --}}
    <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div>
                <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;">Revenue vs Expenses</h3>
                <p style="font-size:0.8125rem;color:#8898aa;margin-top:2px;">Last 6 months</p>
            </div>
        </div>
        <canvas id="revenueChart" height="80"></canvas>
    </div>

    {{-- ── Top Clients + Invoice Breakdown ─────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Top Clients --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;">Top Clients by Revenue</h3>
                <span style="font-size:0.75rem;color:#8898aa;">{{ $this->date_from }} – {{ $this->date_to }}</span>
            </div>
            @forelse($topClients as $i => $row)
            @php $client = $row->client; @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;{{ $i < count($topClients) - 1 ? 'border-bottom:1px solid #eef1f6;' : '' }}">
                <div style="display:flex;align-items:center;gap:12px;">
                    <span style="width:26px;height:26px;border-radius:50%;background:#0a1628;color:#fff;font-size:0.6875rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $i + 1 }}</span>
                    <div>
                        <p style="font-size:0.875rem;font-weight:600;color:#0d1b2e;">{{ $client?->firstname }} {{ $client?->lastname }}</p>
                        <p style="font-size:0.75rem;color:#8898aa;">{{ $row->invoice_count }} invoice(s)</p>
                    </div>
                </div>
                <span style="font-size:0.875rem;font-weight:700;color:#10b981;">R {{ number_format($row->total_revenue, 2) }}</span>
            </div>
            @empty
            <p style="font-size:0.875rem;color:#8898aa;padding:16px 0;text-align:center;">No paid invoices in this period.</p>
            @endforelse
        </div>

        {{-- Invoice Breakdown --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
            <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;margin-bottom:16px;">Invoice Status Breakdown</h3>
            @php
                $invColors = [
                    'Draft'         => 'bg-slate-100 text-slate-600',
                    'Sent'          => 'bg-blue-50 text-blue-700',
                    'Paid'          => 'bg-emerald-50 text-emerald-700',
                    'PartiallyPaid' => 'bg-amber-50 text-amber-700',
                    'Overdue'       => 'bg-rose-50 text-rose-600',
                    'Cancelled'     => 'bg-slate-50 text-slate-500',
                ];
            @endphp
            @forelse($invBreakdown as $status => $row)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #eef1f6;" class="last:border-0">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span class="px-2 py-0.5 rounded-md text-xs font-semibold {{ $invColors[$status] ?? 'bg-slate-100 text-slate-600' }}" style="font-size:0.6875rem;">{{ $status }}</span>
                    <span style="font-size:0.75rem;color:#8898aa;">{{ $row['count'] }} invoice(s)</span>
                </div>
                <span style="font-size:0.875rem;font-weight:600;color:#0d1b2e;font-variant-numeric:tabular-nums;">R {{ number_format($row['total'], 2) }}</span>
            </div>
            @empty
            <p style="font-size:0.875rem;color:#8898aa;padding:16px 0;text-align:center;">No invoices in this period.</p>
            @endforelse
        </div>
    </div>

    {{-- ── Jobs + Lead Sources + Expenses ──────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Jobs by Status --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
            <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;margin-bottom:16px;">Jobs by Status</h3>
            @forelse($jobsBreakdown as $status => $count)
            @php $total = array_sum($jobsBreakdown); $pct = $total > 0 ? round(($count/$total)*100) : 0; @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                    <span style="font-size:0.8125rem;color:#0d1b2e;font-weight:500;">{{ $status }}</span>
                    <span style="font-size:0.75rem;color:#8898aa;">{{ $count }} · {{ $pct }}%</span>
                </div>
                <div style="width:100%;background:#eef1f6;border-radius:4px;height:6px;">
                    <div style="height:6px;border-radius:4px;width:{{ $pct }}%;background:{{ $jobColors[$status] ?? '#0a1628' }};transition:width 400ms ease;"></div>
                </div>
            </div>
            @empty
            <p style="font-size:0.875rem;color:#8898aa;padding:16px 0;text-align:center;">No jobs in this period.</p>
            @endforelse
        </div>

        {{-- Client Acquisition --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
            <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;margin-bottom:16px;">Client Acquisition Sources</h3>
            @forelse($leadSources as $row)
            @php $total = $leadSources->sum('count'); $pct = $total > 0 ? round(($row->count/$total)*100) : 0; @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                    <span style="font-size:0.8125rem;color:#0d1b2e;font-weight:500;text-transform:capitalize;">{{ $row->lead_source ?: 'Unknown' }}</span>
                    <span style="font-size:0.75rem;color:#8898aa;">{{ $row->count }} · {{ $pct }}%</span>
                </div>
                <div style="width:100%;background:#eef1f6;border-radius:4px;height:6px;">
                    <div style="height:6px;border-radius:4px;width:{{ $pct }}%;background:#0a1628;transition:width 400ms ease;"></div>
                </div>
            </div>
            @empty
            <p style="font-size:0.875rem;color:#8898aa;padding:16px 0;text-align:center;">No new clients in this period.</p>
            @endforelse
        </div>

        {{-- Expenses by Category --}}
        <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
            <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;margin-bottom:16px;">Expenses by Category</h3>
            @forelse($expBreakdown as $row)
            @php $totalExp = $expBreakdown->sum('total'); $pct = $totalExp > 0 ? round(($row->total/$totalExp)*100) : 0; @endphp
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                    <span style="font-size:0.8125rem;color:#0d1b2e;font-weight:500;">{{ optional($row->category)->name ?? 'Uncategorised' }}</span>
                    <span style="font-size:0.75rem;color:#8898aa;">R {{ number_format($row->total, 2) }}</span>
                </div>
                <div style="width:100%;background:#eef1f6;border-radius:4px;height:6px;">
                    <div style="height:6px;border-radius:4px;width:{{ $pct }}%;background:#f43f5e;transition:width 400ms ease;"></div>
                </div>
            </div>
            @empty
            <p style="font-size:0.875rem;color:#8898aa;padding:16px 0;text-align:center;">No expenses in this period.</p>
            @endforelse
        </div>
    </div>

    {{-- ── Export ───────────────────────────────────────────────── --}}
    <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
        <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;margin-bottom:16px;">Export Data</h3>
        <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
            <button wire:click="exportInvoices"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#0a1628;color:#fff;font-size:0.875rem;font-weight:600;border-radius:6px;border:none;cursor:pointer;transition:background 150ms ease;"
                    onmouseover="this.style.background='#0f2040'" onmouseout="this.style.background='#0a1628'">
                <svg style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Invoices CSV
            </button>
            <button wire:click="exportExpenses"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#fff;color:#0d1b2e;font-size:0.875rem;font-weight:600;border-radius:6px;border:1px solid #e4e9f0;cursor:pointer;transition:background 150ms ease;"
                    onmouseover="this.style.background='#f4f6f9'" onmouseout="this.style.background='#fff'">
                <svg style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Expenses CSV
            </button>
            <button wire:click="exportJobs"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#fff;color:#0d1b2e;font-size:0.875rem;font-weight:600;border-radius:6px;border:1px solid #e4e9f0;cursor:pointer;transition:background 150ms ease;"
                    onmouseover="this.style.background='#f4f6f9'" onmouseout="this.style.background='#fff'">
                <svg style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Jobs CSV
            </button>
            <span style="font-size:0.8125rem;color:#8898aa;">Period: {{ $this->date_from }} to {{ $this->date_to }}</span>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        function initRevenueChart() {
            const ctx = document.getElementById('revenueChart');
            if (!ctx || window._revenueChart) return;

            window._revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels:   @json($chart['labels']),
                    datasets: [
                        {
                            label:            'Revenue (R)',
                            data:             @json($chart['revenue']),
                            borderColor:      '#0a1628',
                            backgroundColor:  'rgba(10,22,40,0.05)',
                            fill:             true,
                            tension:          0.4,
                            pointBackgroundColor: '#0a1628',
                            pointRadius:      4,
                            pointHoverRadius: 6,
                            borderWidth:      2,
                        },
                        {
                            label:            'Expenses (R)',
                            data:             @json($chart['expenses']),
                            borderColor:      '#f43f5e',
                            backgroundColor:  'rgba(244,63,94,0.05)',
                            fill:             true,
                            tension:          0.4,
                            pointBackgroundColor: '#f43f5e',
                            pointRadius:      4,
                            pointHoverRadius: 6,
                            borderWidth:      2,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { family: 'Inter', size: 12 }, color: '#5a6a7e', boxWidth: 10, padding: 16 }
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#0d1b2e',
                            bodyColor: '#5a6a7e',
                            borderColor: '#e4e9f0',
                            borderWidth: 1,
                            padding: 12,
                            titleFont: { family: 'Inter', weight: '600' },
                            bodyFont: { family: 'Inter' },
                            callbacks: { label: ctx => ctx.dataset.label + ': R ' + ctx.parsed.y.toFixed(2) }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { family: 'Inter', size: 11 }, color: '#8898aa' } },
                        y: {
                            grid: { color: 'rgba(228,233,240,0.8)', drawBorder: false },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#8898aa', callback: val => '{{ \App\Models\BusinessSetup::currencySymbol() }} ' + val.toLocaleString() }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initRevenueChart);
        document.addEventListener('livewire:navigated', () => {
            if (window._revenueChart) { window._revenueChart.destroy(); delete window._revenueChart; }
            initRevenueChart();
        });
    </script>

    <x-filament-actions::modals />
</x-filament-panels::page>
