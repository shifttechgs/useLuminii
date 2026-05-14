<x-filament-widgets::widget>
    <div style="background:#fff;border-radius:12px;border:1px solid #e4e9f0;padding:24px;box-shadow:0 1px 2px rgba(13,27,46,0.04);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div>
                <h3 style="font-size:0.9375rem;font-weight:650;color:#0d1b2e;letter-spacing:-0.02em;">Revenue vs Expenses</h3>
                <p style="font-size:0.8125rem;color:#8898aa;margin-top:2px;">Last 6 months</p>
            </div>
        </div>
        <canvas id="dashboardRevenueChart" height="80"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        function initDashboardRevenueChart() {
            const ctx = document.getElementById('dashboardRevenueChart');
            if (!ctx || window._dashboardRevenueChart) return;

            window._dashboardRevenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels:   @json($labels),
                    datasets: [
                        {
                            label:            'Revenue (R)',
                            data:             @json($revenue),
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
                            data:             @json($expenses),
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
                            callbacks: { label: ctx => ctx.dataset.label + ': {{ \App\Models\BusinessSetup::currencySymbol() }} ' + ctx.parsed.y.toFixed(2) }
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

        document.addEventListener('DOMContentLoaded', initDashboardRevenueChart);
        document.addEventListener('livewire:navigated', () => {
            if (window._dashboardRevenueChart) { window._dashboardRevenueChart.destroy(); delete window._dashboardRevenueChart; }
            initDashboardRevenueChart();
        });
    </script>
</x-filament-widgets::widget>
