<x-filament-widgets::widget class="h-full">
    <div class="h-full rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm overflow-hidden flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 shrink-0">
            <div>
                <p class="text-sm font-bold text-gray-900 dark:text-white">What Needs Action</p>
                <p class="text-xs text-gray-400 mt-0.5">Sorted by urgency — act on these first</p>
            </div>
            @if(!empty($priorities))
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-bold shrink-0 ml-3">
                    {{ count($priorities) }}
                </span>
            @endif
        </div>

        {{-- Rows --}}
        <div class="flex-1">
            @if(empty($priorities))
                <div class="flex items-center gap-3 px-6 py-6">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-950 flex items-center justify-center shrink-0">
                        <x-filament::icon icon="heroicon-o-check-circle" class="w-4 h-4 text-emerald-500" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">All clear</p>
                        <p class="text-xs text-gray-400 mt-0.5">No overdue invoices, cold leads, or pending actions.</p>
                    </div>
                </div>
            @else
                <div class="divide-y divide-gray-50 dark:divide-gray-800/60">
                    @foreach($priorities as $item)
                    @php
                        $iconCls  = match($item['level']) { 'danger' => 'text-red-400', 'warning' => 'text-amber-400', default => 'text-blue-400' };
                        $badgeCls = match($item['level']) {
                            'danger'  => 'bg-red-50 text-red-600 dark:bg-red-950/50 dark:text-red-400',
                            'warning' => 'bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400',
                            default   => 'bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400',
                        };
                        $badgeText = match($item['level']) { 'danger' => 'Urgent', 'warning' => 'Soon', default => 'FYI' };
                        $ctaCls    = match($item['level']) {
                            'danger'  => 'text-red-500 dark:text-red-400 hover:text-red-700',
                            'warning' => 'text-amber-500 dark:text-amber-400 hover:text-amber-700',
                            default   => 'text-blue-500 dark:text-blue-400 hover:text-blue-700',
                        };
                    @endphp
                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                        <x-filament::icon :icon="$item['icon']" class="w-4 h-4 shrink-0 {{ $iconCls }}" />
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $item['title'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item['detail'] }}</p>
                        </div>
                        <div class="shrink-0 flex items-center gap-3 pl-2">
                            <span class="hidden sm:inline-flex text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded {{ $badgeCls }}">{{ $badgeText }}</span>
                            <a href="{{ $item['url'] }}" class="inline-flex items-center gap-0.5 text-xs font-semibold whitespace-nowrap no-underline {{ $ctaCls }}">
                                {{ $item['cta'] }}
                                <x-filament::icon icon="heroicon-m-arrow-right" class="w-3 h-3" />
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-filament-widgets::widget>
