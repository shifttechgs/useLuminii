@php
    /* Generate polyline points for a full-width sparkline (300×40 viewBox) */
    function luminiiSparkPoints(array $vals, int $w = 300, int $h = 40): string {
        if (count($vals) < 2) return '';
        $max   = max($vals) ?: 1;
        $min   = min($vals);
        $range = ($max - $min) ?: 1;
        $step  = $w / (count($vals) - 1);
        $pad   = 4;
        return collect($vals)->map(function ($v, $i) use ($step, $h, $min, $range, $pad) {
            $x = round($i * $step, 1);
            $y = round($h - $pad - (($v - $min) / $range) * ($h - $pad * 2), 1);
            return "{$x},{$y}";
        })->join(' ');
    }
    function luminiiSparkFill(array $vals, int $w = 300, int $h = 40): string {
        $pts = luminiiSparkPoints($vals, $w, $h);
        if (!$pts) return '';
        $parts  = explode(' ', $pts);
        $firstX = explode(',', $parts[0])[0];
        $lastX  = explode(',', $parts[count($vals) - 1])[0];
        return "M {$firstX},{$h} L {$pts} L {$lastX},{$h} Z";
    }

    $sym = \App\Models\BusinessSetup::currencySymbol();
    $cards = [
        [
            'label'   => 'Revenue',
            'context' => 'paid this month',
            'value'   => $sym . ' ' . number_format($collected, 0),
            'change'  => $collectedChange,
            'note'    => $collectedChange === null ? 'no prior month to compare' : null,
            'spark'   => $collectedSpark,
            'url'     => '/useluminii/invoices',
            'stroke'  => '#7c3aed',
            'fill'    => 'rgba(124,58,237,0.07)',
        ],
        [
            'label'    => 'Outstanding',
            'context'  => 'owed to you',
            'value'    => $sym . ' ' . number_format($outstanding, 0),
            'change'   => null,
            'note'     => $overdueCount > 0 ? "{$overdueCount} invoice" . ($overdueCount > 1 ? 's' : '') . ' overdue' : ($outstanding > 0 ? 'invoices sent, awaiting payment' : 'all invoices settled'),
            'note_red' => $overdueCount > 0,
            'spark'    => $outstandingSpark,
            'url'      => '/useluminii/invoices',
            'stroke'   => $outstanding > 0 ? '#d97706' : '#9ca3af',
            'fill'     => $outstanding > 0 ? 'rgba(217,119,6,0.07)' : 'rgba(156,163,175,0.04)',
        ],
        [
            'label'   => 'New Leads',
            'context' => 'this month',
            'value'   => (string) $newLeads,
            'change'  => $leadsChange,
            'note'    => $leadsChange === null ? 'no prior month to compare' : null,
            'spark'   => $leadsSpark,
            'url'     => '/useluminii/leads',
            'stroke'  => '#059669',
            'fill'    => 'rgba(5,150,105,0.07)',
        ],
        [
            'label'   => 'Pipeline',
            'context' => 'value of open quotes',
            'value'   => $sym . ' ' . number_format($pipelineValue, 0),
            'change'  => $pipelineChange,
            'note'    => $pipelineCount > 0
                ? $pipelineCount . ' ' . ($pipelineCount === 1 ? 'quote' : 'quotes') . ' waiting on client'
                : 'no quotes sent yet',
            'spark'   => $pipelineSpark,
            'url'     => '/useluminii/quotes',
            'stroke'  => '#2563eb',
            'fill'    => 'rgba(37,99,235,0.07)',
        ],
        [
            'label'   => 'Active Jobs',
            'context' => 'in progress now',
            'value'   => (string) $activeJobs,
            'change'  => $activeJobsChange,
            'note'    => $completedMonth > 0
                ? $completedMonth . ' ' . ($completedMonth === 1 ? 'job' : 'jobs') . ' completed this month'
                : 'none completed this month',
            'spark'   => $activeJobsSpark,
            'url'     => '/useluminii/jobs',
            'stroke'  => '#0891b2',
            'fill'    => 'rgba(8,145,178,0.07)',
        ],
    ];
@endphp

<x-filament-widgets::widget>
    <div style="display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:1rem;">
        @foreach($cards as $card)
        @php
            $pts      = luminiiSparkPoints($card['spark']);
            $fillPath = luminiiSparkFill($card['spark']);
            $hasSpark = $pts && max($card['spark']) > 0;
            $up       = isset($card['change']) && $card['change'] !== null && $card['change'] >= 0;
            $down     = isset($card['change']) && $card['change'] !== null && $card['change'] < 0;
        @endphp

        <a href="{{ $card['url'] }}"
           class="group relative overflow-hidden rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm hover:shadow-md hover:-translate-y-px transition-all duration-150 no-underline"
           style="padding: 20px 20px {{ $hasSpark ? '44px' : '20px' }} 20px">

            {{-- Label row --}}
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.12em]">{{ $card['label'] }}</p>
                <x-filament::icon icon="heroicon-o-arrow-top-right-on-square"
                    class="w-3 h-3 text-gray-200 dark:text-gray-700 group-hover:text-gray-400 transition-colors shrink-0" />
            </div>

            {{-- Sub-context --}}
            <p class="mt-1 text-[11px] text-gray-400 dark:text-gray-500 leading-snug">{{ $card['context'] }}</p>

            {{-- Number --}}
            <p class="mt-3 text-[28px] font-extrabold text-gray-900 dark:text-white leading-none tracking-tight">
                {{ $card['value'] }}
            </p>

            {{-- Trend / note --}}
            <div class="mt-1.5 flex items-center gap-1.5 min-h-[18px]">
                @if($up || $down)
                    <span class="text-[11px] font-bold {{ $up ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500' }}">
                        {{ $up ? '▲' : '▼' }} {{ abs($card['change']) }}%
                    </span>
                    <span class="text-[11px] text-gray-400">vs last month</span>
                @elseif(!empty($card['note']))
                    <span class="text-[11px] font-medium {{ !empty($card['note_red']) ? 'text-red-500' : 'text-gray-400' }}">
                        {{ $card['note'] }}
                    </span>
                @endif
            </div>

            {{-- Full-width sparkline at the bottom edge --}}
            @if($hasSpark)
            <div class="absolute bottom-0 left-0 right-0 h-10 pointer-events-none">
                <svg viewBox="0 0 300 40" preserveAspectRatio="none" class="w-full h-full">
                    @if($fillPath)
                        <path d="{{ $fillPath }}" fill="{{ $card['fill'] }}" />
                    @endif
                    <polyline
                        points="{{ $pts }}"
                        fill="none"
                        stroke="{{ $card['stroke'] }}"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        opacity="0.8" />
                </svg>
            </div>
            @endif

        </a>
        @endforeach
    </div>
</x-filament-widgets::widget>
