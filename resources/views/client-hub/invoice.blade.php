<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->invoice_id }} — {{ $business->business_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background:#f5f3ef; font-family:'Inter',sans-serif; }
        @media (min-width: 1024px) {
            .sidebar { position: sticky; top: 24px; }
        }
        .status-sent        { background:#dbeafe; color:#1d4ed8; }
        .status-paid        { background:#dcfce7; color:#166534; }
        .status-overdue     { background:#fee2e2; color:#991b1b; }
        .status-partiallypaid { background:#fef9c3; color:#854d0e; }
        .status-draft       { background:#f1f5f9; color:#475569; }
        .status-cancelled   { background:#f1f5f9; color:#9ca3af; }
    </style>
</head>
<body class="min-h-screen">

{{-- Top brand bar --}}
<div style="height:4px;background:#1a3a2a;"></div>

{{-- Header --}}
<header class="bg-white" style="border-bottom:1px solid #ede9e3;">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ $business->website ?? '#' }}" target="_blank" class="flex items-center">
            @if(!empty($logoUrl))
                <img src="{{ $logoUrl }}" alt="{{ $business->business_name }}" style="height:32px;width:auto;">
            @else
                <span style="font-size:15px;font-weight:700;color:#1a3a2a;">{{ $business->business_name }}</span>
            @endif
        </a>
        <div class="flex items-center gap-3">
            <span style="font-family:monospace;font-size:12px;color:#a8a29e;font-weight:600;">{{ $invoice->invoice_id }}</span>
            @php
                $badgeClass = match($invoice->status) {
                    'Paid'          => 'status-paid',
                    'Sent'          => 'status-sent',
                    'Overdue'       => 'status-overdue',
                    'PartiallyPaid' => 'status-partiallypaid',
                    'Cancelled'     => 'status-cancelled',
                    default         => 'status-draft',
                };
                $badgeLabel = $invoice->status === 'PartiallyPaid' ? 'Partially Paid' : $invoice->status;
            @endphp
            <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full {{ $badgeClass }}">
                {{ $badgeLabel }}
            </span>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-8">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm font-medium" style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm font-medium" style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif
    @if(session('info'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm font-medium" style="background:#dbeafe;border:1px solid #bfdbfe;color:#1d4ed8;">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('info') }}
    </div>
    @endif

    {{-- Overdue nudge --}}
    @if($invoice->status === 'Overdue')
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm font-medium" style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        This invoice is <strong>overdue</strong>. Please make payment as soon as possible to avoid disruption of services.
    </div>
    @endif

    {{-- Two-column grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

        {{-- ── LEFT: Invoice document ─────────────────────────────── --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Invoice header card --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #ede9e3;">
                <div class="px-7 py-5" style="border-bottom:1px solid #ede9e3;">
                    <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Invoice from {{ $business->business_name }}</p>
                    <h1 class="text-xl font-bold" style="color:#1c1917;letter-spacing:-0.3px;">
                        {{ optional($invoice->client)->company ?: trim(optional($invoice->client)->firstname . ' ' . optional($invoice->client)->lastname) }}
                    </h1>
                    <p class="text-sm mt-1" style="color:#78716c;">
                        Billed to
                        <strong style="color:#1c1917;">
                            @if(optional($invoice->client)->company)
                                {{ optional($invoice->client)->company }}
                                <span class="font-normal">· {{ trim(optional($invoice->client)->firstname . ' ' . optional($invoice->client)->lastname) }}</span>
                            @else
                                {{ trim(optional($invoice->client)->firstname . ' ' . optional($invoice->client)->lastname) }}
                            @endif
                        </strong>
                    </p>
                </div>
                <div class="grid grid-cols-3 divide-x" style="border-color:#ede9e3;">
                    <div class="px-6 py-4">
                        <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Invoice No.</p>
                        <p class="text-xs font-bold" style="color:#1c1917;font-family:monospace;">{{ $invoice->invoice_id }}</p>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Issued</p>
                        <p class="text-xs font-semibold" style="color:#1c1917;">{{ $invoice->invoice_date?->format('d M Y') ?? '—' }}</p>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Due Date</p>
                        <p class="text-xs font-semibold" style="color:{{ $invoice->status === 'Overdue' ? '#dc2626' : '#1c1917' }};">
                            {{ $invoice->due_date?->format('d M Y') ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Line items --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #ede9e3;">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background:#1a3a2a;">
                            <th class="px-7 py-3 text-left text-[9px] font-bold uppercase tracking-wider text-white">Service / Description</th>
                            <th class="px-4 py-3 text-center text-[9px] font-bold uppercase tracking-wider text-white w-12">Qty</th>
                            <th class="px-5 py-3 text-right text-[9px] font-bold uppercase tracking-wider text-white w-28">Unit</th>
                            <th class="px-7 py-3 text-right text-[9px] font-bold uppercase tracking-wider text-white w-28">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $i => $item)
                        <tr style="background:{{ $i % 2 === 0 ? '#ffffff' : '#faf9f7' }};border-bottom:1px solid #f3f0eb;">
                            <td class="px-7 py-3.5 font-medium" style="color:#44403c;">{{ $item->description }}</td>
                            <td class="px-4 py-3.5 text-center" style="color:#78716c;">{{ $item->quantity }}</td>
                            <td class="px-5 py-3.5 text-right" style="color:#78716c;">R&nbsp;{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-7 py-3.5 text-right font-semibold" style="color:#1c1917;">R&nbsp;{{ number_format($item->line_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Totals --}}
                @php
                    // Always derive from items so stale DB cache never shows wrong amounts
                    $subTotal    = $invoice->items->sum('line_total');
                    $discount    = (float) ($invoice->discount ?? 0);
                    $totalAmount = max(0, $subTotal - $discount);
                    $depositPaid = (float) ($invoice->deposit_paid ?? 0);
                    $balance     = max(0, $totalAmount - $depositPaid);
                @endphp
                <div class="px-7 py-4 flex justify-end" style="background:#faf9f7;border-top:1px solid #ede9e3;">
                    <div class="w-64 space-y-2 text-sm">
                        @if($discount > 0)
                        <div class="flex justify-between" style="color:#78716c;">
                            <span>Subtotal</span><span>R&nbsp;{{ number_format($subTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between" style="color:#16a34a;">
                            <span>Discount</span><span>&minus;R&nbsp;{{ number_format($discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between font-bold text-base pt-2" style="color:#1c1917;border-top:1.5px solid #ede9e3;">
                            <span>Invoice Total</span><span>R&nbsp;{{ number_format($totalAmount, 2) }}</span>
                        </div>
                        @if($depositPaid > 0)
                        <div class="flex justify-between text-xs font-semibold" style="color:#b45309;">
                            <span>Deposit Paid</span><span>&minus;R&nbsp;{{ number_format($depositPaid, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-base pt-2" style="color:{{ $balance <= 0 ? '#166534' : '#991b1b' }};border-top:1.5px solid #ede9e3;">
                            <span>Balance Due</span><span>R&nbsp;{{ number_format($balance, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Client message / Notes --}}
            @if($invoice->client_message)
            <div class="bg-white rounded-2xl px-7 py-5" style="border:1px solid #ede9e3;border-left:3px solid #1a3a2a;">
                <p class="text-[9px] font-bold uppercase tracking-widest mb-2" style="color:#a8a29e;">Notes</p>
                <p class="text-sm leading-relaxed whitespace-pre-line" style="color:#44403c;">{{ $invoice->client_message }}</p>
            </div>
            @endif

        </div>
        {{-- end left --}}

        {{-- ── RIGHT: Sidebar ────────────────────────────────────── --}}
        <div class="lg:col-span-2 sidebar space-y-4">

            @if($invoice->status === 'Paid')

            {{-- Paid confirmation --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #bbf7d0;">
                <div class="px-6 py-5 text-center" style="background:#f0fdf4;border-bottom:1px solid #dcfce7;">
                    <div style="width:44px;height:44px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                        <svg style="width:20px;height:20px;" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-sm" style="color:#166534;">Invoice Paid!</p>
                    @if($invoice->paid_at)
                    <p class="text-xs mt-0.5" style="color:#4d7c0f;">Paid {{ $invoice->paid_at->format('d M Y') }}</p>
                    @endif
                </div>
                <div class="px-6 py-5 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Invoice</span>
                        <span class="font-semibold" style="color:#1c1917;font-family:monospace;">{{ $invoice->invoice_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Amount Paid</span>
                        <span class="font-bold" style="color:#166534;">R&nbsp;{{ number_format($totalAmount, 2) }}</span>
                    </div>
                    @if($invoice->payment_method)
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Method</span>
                        <span class="font-semibold" style="color:#1c1917;">{{ ucfirst($invoice->payment_method) }}</span>
                    </div>
                    @endif
                    @if($invoice->paypal_capture_id)
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">PayPal Ref</span>
                        <span class="font-semibold text-xs" style="color:#1c1917;">{{ $invoice->paypal_capture_id }}</span>
                    </div>
                    @endif
                </div>
            </div>

            @elseif($invoice->status === 'Cancelled')

            {{-- Cancelled --}}
            <div class="rounded-2xl p-6 text-center space-y-2" style="background:#faf9f7;border:1px solid #ede9e3;">
                <p class="font-semibold text-sm" style="color:#44403c;">This invoice has been cancelled.</p>
                <p class="text-xs leading-relaxed" style="color:#78716c;">
                    If you believe this is an error, please contact us.
                </p>
                <a href="mailto:{{ $business->email }}" class="inline-block mt-2 text-xs font-semibold" style="color:#1a3a2a;">{{ $business->email }}</a>
            </div>

            @else

            {{-- ── Unpaid / Partially paid / Overdue / Sent / Draft ── --}}

            {{-- Pay online card --}}
            @if(!in_array($invoice->status, ['Draft']))
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #ede9e3;">
                <div class="px-6 py-5" style="border-bottom:1px solid #ede9e3;">
                    <p class="text-[9px] font-bold uppercase tracking-widest mb-0.5" style="color:#a8a29e;">Amount Due</p>
                    <p class="text-2xl font-bold" style="color:{{ $invoice->status === 'Overdue' ? '#dc2626' : '#1c1917' }};">
                        R&nbsp;{{ number_format($balance, 2) }}
                    </p>
                    @if($depositPaid > 0)
                    <p class="text-xs mt-1" style="color:#b45309;">Deposit of R&nbsp;{{ number_format($depositPaid, 2) }} already applied</p>
                    @endif
                </div>
                <div class="p-5 space-y-3">

                    {{-- PayPal CTA --}}
                    <a href="{{ route('client-hub.payment.checkout', $invoice->view_token) }}"
                       class="w-full flex items-center justify-center gap-2.5 py-3 rounded-xl font-bold text-sm transition-opacity hover:opacity-90"
                       style="background:#ffc439;color:#003087;">
                        <svg style="width:18px;height:18px;" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.27-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.487z"/>
                        </svg>
                        Pay with PayPal
                    </a>
                    <p class="text-[10px] text-center" style="color:#a8a29e;">Secured by PayPal · Visa, Mastercard &amp; PayPal Balance accepted</p>

                    <div class="flex items-center gap-3 py-1">
                        <div style="flex:1;height:1px;background:#ede9e3;"></div>
                        <span style="font-size:10px;color:#a8a29e;font-weight:600;">OR PAY BY EFT</span>
                        <div style="flex:1;height:1px;background:#ede9e3;"></div>
                    </div>

                    <p class="text-xs text-center leading-relaxed" style="color:#78716c;">
                        Use <strong style="color:#1c1917;">{{ $invoice->invoice_id }}</strong> as your payment reference.
                    </p>

                </div>
            </div>
            @else
            {{-- Draft state --}}
            <div class="rounded-2xl p-6 text-center space-y-2" style="background:#fafafa;border:1px solid #ede9e3;">
                <p class="font-semibold text-sm" style="color:#44403c;">Invoice not yet finalised.</p>
                <p class="text-xs leading-relaxed" style="color:#78716c;">This invoice is still being prepared. You will receive the final version shortly.</p>
            </div>
            @endif

            @endif
            {{-- end status conditions --}}

            {{-- EFT Payment details --}}
            @if($business->bank_account_number && !in_array($invoice->status, ['Paid', 'Cancelled']))
            <div class="bg-white rounded-2xl px-6 py-5" style="border:1px solid #ede9e3;">
                <p class="text-[9px] font-bold uppercase tracking-widest mb-4" style="color:#a8a29e;">Payment Details</p>
                <div class="space-y-3 text-sm">
                    @if($business->bank_name)
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Bank</span>
                        <span class="font-semibold" style="color:#1c1917;">{{ $business->bank_name }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Account No.</span>
                        <span class="font-semibold" style="color:#1c1917;">{{ $business->bank_account_number }}</span>
                    </div>
                    @if($business->bank_account_name)
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Account Holder</span>
                        <span class="font-semibold" style="color:#1c1917;">{{ $business->bank_account_name }}</span>
                    </div>
                    @endif
                    @if($business->bank_account_type)
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Account Type</span>
                        <span class="font-semibold" style="color:#1c1917;">{{ ucfirst($business->bank_account_type) }}</span>
                    </div>
                    @endif
                    @if($business->bank_branch_code)
                    <div class="flex justify-between">
                        <span style="color:#a8a29e;">Branch Code</span>
                        <span class="font-semibold" style="color:#1c1917;">{{ $business->bank_branch_code }}</span>
                    </div>
                    @endif
                </div>
                <div class="mt-4 px-3 py-2.5 rounded-lg text-xs" style="background:#fffbeb;color:#92400e;">
                    Use <strong>{{ $invoice->invoice_id }}</strong> as reference.
                    Amount due: <strong>R&nbsp;{{ number_format($balance, 2) }}</strong>.
                </div>
                @if($business->payment_instructions)
                <p class="mt-3 text-xs leading-relaxed" style="color:#a8a29e;">{{ $business->payment_instructions }}</p>
                @endif
            </div>
            @endif

            {{-- Contact line --}}
            <p class="text-xs text-center" style="color:#a8a29e;">
                <a href="mailto:{{ $business->email }}" style="color:#1a3a2a;font-weight:600;">{{ $business->email }}</a>
                @if($business->phone) &middot; {{ $business->phone }}@endif
            </p>

        </div>
        {{-- end sidebar --}}

    </div>
    {{-- end grid --}}

    <p class="text-center text-[10px] mt-8 pb-6" style="color:#d6d3d1;">&copy; {{ date('Y') }} {{ $business->business_name }}. All rights reserved.</p>

</main>

{{-- Bottom brand bar --}}
<div style="height:3px;background:#1a3a2a;"></div>

</body>
</html>
