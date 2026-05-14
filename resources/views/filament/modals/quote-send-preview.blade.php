<div class="font-sans text-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-gray-100 dark:border-gray-700">
        <div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white tracking-tight">Review &amp; Send Quote</h2>
            <p class="mt-0.5 text-xs text-gray-400">Confirm the details before sending to the client.</p>
        </div>
        <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-700">
            Draft
        </span>
    </div>

    <div class="px-6 py-5 space-y-4">

        {{-- Recipient row --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background:#1a3a2a;">
                    {{ strtoupper(substr(optional($quote->client)->company ?: optional($quote->client)->firstname, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white text-sm leading-tight">
                        {{ optional($quote->client)->company ?: trim(optional($quote->client)->firstname . ' ' . optional($quote->client)->lastname) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ optional($quote->client)->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-5 text-right shrink-0">
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Quote #</p>
                    <p class="text-xs font-bold text-gray-700 dark:text-gray-200 font-mono">{{ $quote->quote_id }}</p>
                </div>
                <div class="w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                <div>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-0.5">Valid Until</p>
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-200">
                        {{ $quote->expiry_date ? $quote->expiry_date->format('d M Y') : '—' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Line items --}}
        <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr style="background:#1a3a2a;">
                        <th class="px-4 py-2.5 text-left text-[9px] font-bold uppercase tracking-wider text-white">Service / Description</th>
                        <th class="px-4 py-2.5 text-right text-[9px] font-bold uppercase tracking-wider text-white w-10">Qty</th>
                        <th class="px-4 py-2.5 text-right text-[9px] font-bold uppercase tracking-wider text-white w-24">Unit Price</th>
                        <th class="px-4 py-2.5 text-right text-[9px] font-bold uppercase tracking-wider text-white w-24">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quote->items as $i => $item)
                    <tr class="{{ $i % 2 === 0 ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800/50' }}">
                        <td class="px-4 py-2.5 text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700/50">{{ $item->description }}</td>
                        <td class="px-4 py-2.5 text-right text-gray-500 border-b border-gray-100 dark:border-gray-700/50">{{ $item->quantity }}</td>
                        <td class="px-4 py-2.5 text-right text-gray-500 border-b border-gray-100 dark:border-gray-700/50">R&nbsp;{{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-4 py-2.5 text-right font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700/50">R&nbsp;{{ number_format($item->line_total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals inside the table card --}}
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800/60 border-t border-gray-200 dark:border-gray-700 space-y-1.5">
                @if($quote->discount > 0)
                <div class="flex justify-between text-xs text-gray-500">
                    <span>Subtotal</span>
                    <span>R&nbsp;{{ number_format($quote->sub_total, 2) }}</span>
                </div>
                <div class="flex justify-between text-xs text-green-600 dark:text-green-400">
                    <span>Discount</span>
                    <span>&minus;R&nbsp;{{ number_format($quote->discount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-sm font-bold text-gray-900 dark:text-white {{ $quote->discount > 0 ? 'pt-1.5 border-t border-gray-200 dark:border-gray-600' : '' }}">
                    <span>Grand Total</span>
                    <span>R&nbsp;{{ number_format($quote->grand_total, 2) }}</span>
                </div>
                @if($quote->required_deposit > 0)
                <div class="flex justify-between text-xs font-semibold text-amber-600 dark:text-amber-400">
                    <span>Required Deposit</span>
                    <span>R&nbsp;{{ number_format($quote->required_deposit, 2) }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Client notes --}}
        @if ($quote->client_notes)
        <div class="px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-800 border-l-[3px] text-xs text-gray-600 dark:text-gray-300" style="border-color:#1a3a2a;">
            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Client Notes</p>
            <p class="leading-relaxed">{{ $quote->client_notes }}</p>
        </div>
        @endif

        {{-- Info line --}}
        <p class="text-xs text-gray-400 text-center pb-1">
            The client will receive this quote as a PDF attachment with a link to accept or decline online.
        </p>

    </div>

</div>
