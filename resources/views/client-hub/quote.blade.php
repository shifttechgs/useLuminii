<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quote->quote_id }} — {{ $business->business_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { background:#f5f3ef; font-family:'Inter',sans-serif; }
        dialog { border:none; padding:0; max-width:440px; width:calc(100% - 32px); }
        dialog::backdrop { background:rgba(0,0,0,0.45); }
        .status-sent     { background:#dbeafe; color:#1d4ed8; }
        .status-accepted { background:#dcfce7; color:#166534; }
        .status-declined { background:#fee2e2; color:#991b1b; }
        .status-expired  { background:#fef9c3; color:#854d0e; }
        .status-draft    { background:#f1f5f9; color:#475569; }
        @media (min-width: 1024px) {
            .sidebar { position: sticky; top: 24px; }
        }
    </style>
</head>
<body class="min-h-screen">

{{-- Brand bar --}}
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
            <span style="font-family:monospace;font-size:12px;color:#a8a29e;font-weight:600;">{{ $quote->quote_id }}</span>
            <span class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full
                @if($quote->status === 'Accepted') status-accepted
                @elseif($quote->status === 'Sent') status-sent
                @elseif($quote->status === 'Declined') status-declined
                @elseif($quote->status === 'Expired') status-expired
                @else status-draft @endif">
                {{ $quote->status }}
            </span>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto px-6 py-8">

    {{-- Flash --}}
    @if(session('success') || session('success_comment'))
    <div class="mb-5 flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm font-medium" style="background:#dcfce7;border:1px solid #bbf7d0;color:#166534;">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') ?? session('success_comment') }}
    </div>
    @endif

    {{-- Two-column grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

        {{-- ── LEFT: Quote document ──────────────────────────────── --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Quote header card --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #ede9e3;">
                <div class="px-7 py-5" style="border-bottom:1px solid #ede9e3;">
                    <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Quotation from {{ $business->business_name }}</p>
                    <h1 class="text-xl font-bold" style="color:#1c1917;letter-spacing:-0.3px;">{{ $quote->job_title }}</h1>
                    <p class="text-sm mt-1" style="color:#78716c;">
                        Prepared for
                        <strong style="color:#1c1917;">{{ optional($quote->client)->company ?: trim(optional($quote->client)->firstname . ' ' . optional($quote->client)->lastname) }}</strong>
                    </p>
                </div>
                <div class="grid grid-cols-3 divide-x" style="border-color:#ede9e3;">
                    <div class="px-6 py-4">
                        <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Quote No.</p>
                        <p class="text-xs font-bold" style="color:#1c1917;font-family:monospace;">{{ $quote->quote_id }}</p>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Issued</p>
                        <p class="text-xs font-semibold" style="color:#1c1917;">{{ $quote->quote_date?->format('d M Y') }}</p>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Valid Until</p>
                        <p class="text-xs font-semibold" style="color:#1c1917;">{{ $quote->expiry_date?->format('d M Y') ?? '—' }}</p>
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
                        @foreach($quote->items as $i => $item)
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
                <div class="px-7 py-4 flex justify-end" style="background:#faf9f7;border-top:1px solid #ede9e3;">
                    <div class="w-56 space-y-2 text-sm">
                        @if($quote->discount > 0)
                        <div class="flex justify-between" style="color:#78716c;">
                            <span>Subtotal</span><span>R&nbsp;{{ number_format($quote->sub_total, 2) }}</span>
                        </div>
                        <div class="flex justify-between" style="color:#16a34a;">
                            <span>Discount</span><span>&minus;R&nbsp;{{ number_format($quote->discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between font-bold text-base pt-2" style="color:#1c1917;border-top:1.5px solid #ede9e3;">
                            <span>Grand Total</span><span>R&nbsp;{{ number_format($quote->grand_total, 2) }}</span>
                        </div>
                        @if($quote->required_deposit > 0)
                        <div class="flex justify-between text-xs font-semibold" style="color:#b45309;">
                            <span>Required Deposit</span><span>R&nbsp;{{ number_format($quote->required_deposit, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($quote->client_notes)
            <div class="bg-white rounded-2xl px-7 py-5" style="border:1px solid #ede9e3;border-left:3px solid #1a3a2a;">
                <p class="text-[9px] font-bold uppercase tracking-widest mb-2" style="color:#a8a29e;">Notes</p>
                <p class="text-sm leading-relaxed whitespace-pre-line" style="color:#44403c;">{{ $quote->client_notes }}</p>
            </div>
            @endif

        </div>

        {{-- ── RIGHT: Sidebar ────────────────────────────────────── --}}
        <div class="lg:col-span-2 sidebar space-y-4">

            {{-- Decision card --}}
            @php
                $daysLeft = $quote->expiry_date ? now()->diffInDays($quote->expiry_date, false) : null;
            @endphp

            @if($quote->status === 'Sent')

            {{-- Expiry nudge --}}
            @if($daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 3)
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium" style="background:#fefce8;border:1px solid #fde047;color:#854d0e;">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @if($daysLeft === 0)
                    This quote expires <strong>today</strong>. Approve it to lock in the price.
                @elseif($daysLeft === 1)
                    This quote expires <strong>tomorrow</strong>. Approve it to lock in the price.
                @else
                    This quote expires in <strong>{{ $daysLeft }} days</strong>. Approve it to lock in the price.
                @endif
            </div>
            @endif

            {{-- CTA card --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #ede9e3;">
                <div class="px-6 py-5" style="border-bottom:1px solid #ede9e3;">
                    <p class="text-[9px] font-bold uppercase tracking-widest mb-0.5" style="color:#a8a29e;">Take Action</p>
                    <p class="text-sm font-semibold" style="color:#1c1917;">How would you like to proceed?</p>
                </div>
                <div class="p-5 space-y-2.5">

                    {{-- Primary: Approve --}}
                    <button onclick="document.getElementById('modal-approve').showModal()"
                        class="w-full inline-flex items-center justify-center gap-2 text-white text-sm font-semibold py-3 rounded-xl hover:opacity-90 transition-opacity"
                        style="background:#1a3a2a;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Approve &amp; Get Started
                    </button>

                    {{-- Secondary: Question --}}
                    <button onclick="document.getElementById('modal-question').showModal()"
                        class="w-full inline-flex items-center justify-center gap-2 text-sm font-semibold py-3 rounded-xl border hover:bg-gray-50 transition-colors"
                        style="color:#44403c;border-color:#ede9e3;background:#fff;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        I Have a Question
                    </button>

                    {{-- Tertiary: Not right now --}}
                    <button onclick="document.getElementById('modal-decline').showModal()"
                        class="w-full text-xs font-medium py-2 rounded-xl transition-colors hover:underline"
                        style="color:#a8a29e;background:transparent;">
                        Not right now
                    </button>

                </div>
            </div>

            {{-- ── Approve modal ────────────────────────────────── --}}
            <dialog id="modal-approve" class="rounded-2xl shadow-2xl p-0 backdrop:bg-black/40" style="border:1px solid #ede9e3;">
                <div class="px-7 py-5" style="border-bottom:1px solid #ede9e3;">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Confirm Approval</p>
                            <p class="text-base font-bold leading-tight" style="color:#1c1917;">Let's get started!</p>
                        </div>
                        <div style="width:40px;height:40px;background:#e8f0ec;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:18px;height:18px;" fill="none" stroke="#1a3a2a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('client-hub.quote.accept', $quote->accepted_token) }}" class="p-7 space-y-5">
                    @csrf
                    <div class="flex items-center justify-between px-4 py-3 rounded-xl text-sm" style="background:#faf9f7;border:1px solid #ede9e3;">
                        <span style="color:#78716c;">{{ $quote->job_title }}</span>
                        <span class="font-bold" style="color:#1c1917;">R&nbsp;{{ number_format($quote->grand_total, 2) }}</span>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-2" style="color:#44403c;">
                            Any notes for us?
                            <span class="font-normal ml-1" style="color:#a8a29e;">Optional</span>
                        </label>
                        <textarea name="comment" rows="3"
                            placeholder="Start date preferences, questions about the scope, anything at all…"
                            class="w-full rounded-xl text-sm px-4 py-3 resize-none focus:outline-none"
                            style="border:1px solid #ede9e3;background:#faf9f7;color:#1c1917;"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('modal-approve').close()"
                            class="flex-1 text-sm font-medium py-2.5 rounded-xl border hover:bg-gray-50 transition-colors"
                            style="color:#78716c;border-color:#ede9e3;">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 text-white text-sm font-semibold py-2.5 rounded-xl hover:opacity-90 transition-opacity"
                            style="background:#1a3a2a;">
                            Confirm &amp; Approve
                        </button>
                    </div>
                </form>
            </dialog>

            {{-- ── Question modal ───────────────────────────────── --}}
            <dialog id="modal-question" class="rounded-2xl shadow-2xl p-0 backdrop:bg-black/40" style="border:1px solid #ede9e3;">
                <div class="px-7 py-5" style="border-bottom:1px solid #ede9e3;">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Ask Us Anything</p>
                            <p class="text-base font-bold leading-tight" style="color:#1c1917;">Happy to help</p>
                        </div>
                        <div style="width:40px;height:40px;background:#eff6ff;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:18px;height:18px;" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('client-hub.quote.comment', $quote->accepted_token) }}" class="p-7 space-y-5">
                    @csrf
                    <p class="text-sm" style="color:#78716c;line-height:1.7;">
                        Not sure about something? Ask away — we will get back to you promptly and the quote will remain open in the meantime.
                    </p>
                    <div>
                        <label class="block text-xs font-semibold mb-2" style="color:#44403c;">Your question</label>
                        <textarea id="question-text" name="message" rows="4" required
                            placeholder="e.g. Can we adjust the scope? What does the timeline look like? Is there flexibility on pricing?…"
                            class="w-full rounded-xl text-sm px-4 py-3 resize-none focus:outline-none"
                            style="border:1px solid #ede9e3;background:#faf9f7;color:#1c1917;"></textarea>
                        <p id="question-error" class="mt-1 text-xs hidden" style="color:#dc2626;">Please enter your question before sending.</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('modal-question').close()"
                            class="flex-1 text-sm font-medium py-2.5 rounded-xl border hover:bg-gray-50 transition-colors"
                            style="color:#78716c;border-color:#ede9e3;">
                            Cancel
                        </button>
                        <button type="button" onclick="submitQuestion()"
                            class="flex-1 text-white text-sm font-semibold py-2.5 rounded-xl hover:opacity-90 transition-opacity"
                            style="background:#1a3a2a;">
                            Send Question
                        </button>
                    </div>
                </form>
            </dialog>

            {{-- ── Decline modal ────────────────────────────────── --}}
            <dialog id="modal-decline" class="rounded-2xl shadow-2xl p-0 backdrop:bg-black/40" style="border:1px solid #ede9e3;">
                <div class="px-7 py-5" style="border-bottom:1px solid #ede9e3;">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest mb-1" style="color:#a8a29e;">Before You Go</p>
                            <p class="text-base font-bold leading-tight" style="color:#1c1917;">We're sorry it didn't work out</p>
                        </div>
                        <div style="width:40px;height:40px;background:#faf9f7;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:18px;height:18px;" fill="none" stroke="#78716c" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('client-hub.quote.decline', $quote->accepted_token) }}" class="p-7 space-y-5" id="form-decline">
                    @csrf
                    <p class="text-sm" style="color:#78716c;line-height:1.7;">
                        We genuinely appreciate you taking the time to consider us. Your feedback helps us improve — and we may be able to find a better fit if you share what held you back.
                    </p>
                    <div>
                        <label class="block text-xs font-semibold mb-2" style="color:#44403c;">
                            Share your thoughts
                            <span class="font-normal ml-1" style="color:#a8a29e;">— what can we do better?</span>
                        </label>
                        <textarea id="decline-reason" name="reason" rows="4" required
                            placeholder="e.g. Budget constraints, timing isn't right, need to revisit the scope — anything helps…"
                            class="w-full rounded-xl text-sm px-4 py-3 resize-none focus:outline-none"
                            style="border:1px solid #ede9e3;background:#faf9f7;color:#1c1917;"></textarea>
                        <p id="decline-error" class="mt-1 text-xs hidden" style="color:#dc2626;">Please share a brief note before proceeding.</p>
                    </div>
                    <p class="text-xs" style="color:#a8a29e;">We may follow up — only to see if there is anything we can do to help.</p>
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('modal-decline').close()"
                            class="flex-1 text-sm font-medium py-2.5 rounded-xl border hover:bg-gray-50 transition-colors"
                            style="color:#78716c;border-color:#ede9e3;">
                            Cancel
                        </button>
                        <button type="button" onclick="submitDecline()"
                            class="flex-1 text-sm font-semibold py-2.5 rounded-xl border hover:bg-gray-100 transition-colors"
                            style="color:#78716c;border-color:#d6d3d1;background:#f5f3ef;">
                            Confirm
                        </button>
                    </div>
                </form>
            </dialog>

            <script>
                function submitDecline() {
                    var r = document.getElementById('decline-reason').value.trim();
                    var e = document.getElementById('decline-error');
                    if (!r) { e.classList.remove('hidden'); return; }
                    e.classList.add('hidden');
                    document.getElementById('form-decline').submit();
                }
                function submitQuestion() {
                    var q = document.getElementById('question-text').value.trim();
                    var e = document.getElementById('question-error');
                    if (!q) { e.classList.remove('hidden'); return; }
                    e.classList.add('hidden');
                    q.closest ? document.getElementById('modal-question').querySelector('form').submit()
                              : document.getElementById('modal-question').querySelector('form').submit();
                }
                ['modal-approve','modal-question','modal-decline'].forEach(function(id) {
                    document.getElementById(id).addEventListener('click', function(e) {
                        if (e.target === this) this.close();
                    });
                });
            </script>

            @elseif($quote->status === 'Accepted')
            {{-- Post-acceptance: what happens next --}}
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #bbf7d0;">
                <div class="px-6 py-5 text-center" style="background:#f0fdf4;border-bottom:1px solid #dcfce7;">
                    <div style="width:44px;height:44px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                        <svg style="width:20px;height:20px;" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-sm" style="color:#166534;">You're confirmed!</p>
                    <p class="text-xs mt-0.5" style="color:#4d7c0f;">Approved {{ $quote->accepted_at?->format('d M Y') }}</p>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <p class="text-[9px] font-bold uppercase tracking-widest" style="color:#a8a29e;">What happens next</p>
                    @foreach([
                        ['We review your approval', 'Your approval is recorded and our team has been notified.'],
                        ['We reach out within 24 hours', 'Expect a call or email to align on next steps and kick-off.'],
                        ['We get to work', 'Your project begins. We keep you updated every step of the way.'],
                    ] as $i => $step)
                    <div class="flex items-start gap-3">
                        <div style="width:22px;height:22px;background:#1a3a2a;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                            <span style="font-size:10px;font-weight:700;color:#fff;">{{ $i + 1 }}</span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold" style="color:#1c1917;">{{ $step[0] }}</p>
                            <p class="text-xs mt-0.5" style="color:#78716c;">{{ $step[1] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @elseif($quote->status === 'Declined')
            <div class="rounded-2xl p-6 text-center space-y-2" style="background:#faf9f7;border:1px solid #ede9e3;">
                <p class="font-semibold text-sm" style="color:#44403c;">Thank you for letting us know.</p>
                <p class="text-xs leading-relaxed" style="color:#78716c;">
                    We appreciate you considering us. If circumstances change or you'd like to revisit this, we'd love to hear from you.
                </p>
                <a href="mailto:{{ $business->email }}" class="inline-block mt-2 text-xs font-semibold" style="color:#1a3a2a;">
                    {{ $business->email }}
                </a>
            </div>

            @elseif($quote->status === 'Expired')
            <div class="rounded-2xl p-6 text-center space-y-2" style="background:#fefce8;border:1px solid #fde047;">
                <p class="font-semibold text-sm" style="color:#854d0e;">This quotation has expired.</p>
                <p class="text-xs" style="color:#78716c;">Prices may have changed. Contact us for an updated quote.</p>
                <a href="mailto:{{ $business->email }}" class="inline-block mt-2 text-xs font-semibold" style="color:#1a3a2a;">{{ $business->email }}</a>
            </div>
            @endif

            {{-- Payment details --}}
            @if($business->bank_account_number && in_array($quote->status, ['Sent','Accepted']))
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
                @if($quote->required_deposit > 0)
                <div class="mt-4 px-3 py-2.5 rounded-lg text-xs" style="background:#fffbeb;color:#92400e;">
                    Use <strong>{{ $quote->quote_id }}</strong> as reference. Deposit of <strong>R&nbsp;{{ number_format($quote->required_deposit, 2) }}</strong> required to confirm.
                </div>
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

<div style="height:3px;background:#1a3a2a;"></div>

</body>
</html>
