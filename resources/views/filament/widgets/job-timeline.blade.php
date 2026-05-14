<x-filament-widgets::widget>
<x-filament::section>
    <x-slot name="heading">Job Timeline</x-slot>

    @php
        $logs     = $this->getLogs();
        $payments = $this->getPayments();
    @endphp

    @if($logs->isEmpty())
        <p class="text-sm text-gray-400 italic">No activity recorded yet.</p>
    @else
    <div class="relative">
        {{-- Vertical line --}}
        <div class="absolute left-4 top-2 bottom-2 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

        <div class="space-y-6 pl-12">
            @foreach($logs as $log)
            @php
                $color = match($log->to_status) {
                    'New'        => 'bg-gray-400',
                    'Scheduled'  => 'bg-blue-500',
                    'InProgress' => 'bg-amber-500',
                    'Completed'  => 'bg-emerald-500',
                    'Cancelled'  => 'bg-red-500',
                    default      => 'bg-gray-400',
                };
                $label = match($log->to_status) {
                    'InProgress' => 'In Progress',
                    default      => $log->to_status,
                };
            @endphp
            <div class="relative">
                {{-- Dot --}}
                <div class="absolute -left-8 top-1 w-4 h-4 rounded-full {{ $color }} border-2 border-white dark:border-gray-900 shadow"></div>

                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold
                                {{ match($log->to_status) {
                                    'Scheduled'  => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                                    'InProgress' => 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300',
                                    'Completed'  => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300',
                                    'Cancelled'  => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                                    default      => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                                } }}">
                                {{ $label }}
                            </span>
                            @if($log->client_notified)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                                Client notified
                            </span>
                            @endif
                        </div>
                        @if($log->note)
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $log->note }}</p>
                        @endif
                        @if($log->from_status)
                        <p class="mt-0.5 text-xs text-gray-400">
                            @if($log->changedBy) {{ $log->changedBy->name }} &middot; @endif
                            {{ $log->from_status }} &rarr; {{ $label }}
                        </p>
                        @else
                        <p class="mt-0.5 text-xs text-gray-400">
                            @if($log->changedBy) {{ $log->changedBy->name }} &middot; @endif
                            Job created
                        </p>
                        @endif
                    </div>
                    <span class="text-xs text-gray-400 whitespace-nowrap shrink-0 pt-1">
                        {{ $log->created_at->format('d M Y H:i') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Payments section --}}
    @if($payments->isNotEmpty())
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Payment History</p>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">
                    <th class="pb-2">Date</th>
                    <th class="pb-2">Type</th>
                    <th class="pb-2">Method</th>
                    <th class="pb-2">Reference</th>
                    <th class="pb-2 text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($payments as $payment)
                <tr>
                    <td class="py-2 text-gray-600 dark:text-gray-300">{{ $payment->received_at->format('d M Y') }}</td>
                    <td class="py-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 capitalize">
                            {{ $payment->type }}
                        </span>
                    </td>
                    <td class="py-2 text-gray-600 dark:text-gray-300">{{ $payment->methodLabel() }}</td>
                    <td class="py-2 font-mono text-xs text-gray-500">{{ $payment->reference ?? '—' }}</td>
                    <td class="py-2 text-right font-semibold text-gray-800 dark:text-gray-200">R&nbsp;{{ number_format($payment->amount, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="pt-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Received</td>
                    <td class="pt-3 text-right font-bold text-emerald-600">R&nbsp;{{ number_format($payments->sum('amount'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

</x-filament::section>
</x-filament-widgets::widget>
