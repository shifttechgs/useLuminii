<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>

* { margin: 0; padding: 0; box-sizing: border-box; }

@page { margin: 0; }

body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 11px;
    color: #111827;
    background: #ffffff;
    line-height: 1.45;
}

.brand-bar { background: #1a3a2a; height: 5px; width: 100%; }

.wrap { padding: 22px 42px 56px; }

/* ── Header ──────────────────────────────────────────────── */
.hdr { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
.hdr td { vertical-align: top; padding: 0; }

.doc-type {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    letter-spacing: -0.5px;
    line-height: 1;
    margin-bottom: 14px;
}

.meta-lbl {
    font-size: 7.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9ca3af;
    margin-bottom: 1px;
}

.meta-val {
    font-size: 11px;
    font-weight: 400;
    color: #111827;
    margin-bottom: 8px;
}

.logo-img {
    max-height: 44px;
    max-width: 175px;
    display: block;
    margin-left: auto;
    margin-bottom: 10px;
}

.co {
    text-align: right;
    font-size: 10.5px;
    color: #6b7280;
    line-height: 1.65;
}

.co-name {
    font-size: 12px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 3px;
}

/* ── Divider ─────────────────────────────────────────────── */
.section-divider {
    border: none;
    border-top: 1px solid #f3f4f6;
    margin: 14px 0;
}

/* ── Bill To ─────────────────────────────────────────────── */
.section-lbl {
    font-size: 7.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9ca3af;
    margin-bottom: 5px;
}

.client-name {
    font-size: 12px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 2px;
}

.client-line {
    font-size: 10.5px;
    color: #4b5563;
    margin-bottom: 1px;
}

/* ── Status badge ────────────────────────────────────────── */
.status-badge {
    display: inline-block;
    padding: 2px 9px;
    border-radius: 20px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #dcfce7;
    color: #166534;
}
.status-overdue { background: #fee2e2; color: #991b1b; }
.status-draft   { background: #f3f4f6; color: #374151; }
.status-sent    { background: #dbeafe; color: #1e40af; }

/* ── Items table ─────────────────────────────────────────── */
.tbl { width: 100%; border-collapse: collapse; margin-top: 16px; }

.tbl thead tr { background: #1a3a2a; }
.tbl thead th {
    padding: 9px 13px;
    font-size: 9px;
    font-weight: 700;
    color: #fff;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.tbl thead th.r { text-align: right; }

.tbl tbody tr { page-break-inside: avoid; }
.tbl tbody tr:nth-child(even) { background: #f9fafb; }
.tbl tbody tr:nth-child(odd)  { background: #ffffff; }
.tbl tbody td {
    padding: 9px 13px;
    font-size: 11px;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
}
.tbl tbody td.r { text-align: right; }

/* ── Totals ──────────────────────────────────────────────── */
.totals {
    width: 100%;
    border-collapse: collapse;
    page-break-inside: avoid;
    page-break-before: avoid;
}
.totals td {
    padding: 3px 13px;
    font-size: 11px;
    color: #6b7280;
    text-align: right;
}
.totals .lc { width: 72%; }
.totals tr.sub  td { padding-top: 10px; color: #374151; }
.totals tr.disc td { color: #16a34a; }
.totals tr.dep  td { font-size: 10.5px; color: #b45309; font-weight: 600; }
.totals tr.grand td {
    padding-top: 8px;
    padding-bottom: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    border-top: 1.5px solid #d1d5db;
}
.totals tr.balance td {
    font-size: 13px;
    font-weight: 700;
    color: #1a3a2a;
    padding-top: 4px;
}

/* ── Cards ───────────────────────────────────────────────── */
.card-wrap { margin-top: 16px; page-break-inside: avoid; }

.card-lbl {
    font-size: 7.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #9ca3af;
    margin-bottom: 5px;
}

.notes-card, .pay-card {
    background: #f9fafb;
    border-left: 3px solid #1a3a2a;
    padding: 10px 14px;
    font-size: 10.5px;
    color: #374151;
    line-height: 1.65;
    page-break-inside: avoid;
}

.pay-tbl { width: 100%; border-collapse: collapse; }
.pay-tbl td { padding: 1px 0; font-size: 10.5px; }
.pay-tbl .pk { width: 40%; color: #9ca3af; }
.pay-tbl .pv { font-weight: 700; color: #111827; }
.pay-tbl .ref { color: #b45309; font-weight: 700; font-size: 12px; }

/* ── Footer ──────────────────────────────────────────────── */
.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 9px 42px 12px;
    border-top: 1px solid #e5e7eb;
    text-align: center;
    background: #ffffff;
}

.footer-logo {
    max-height: 16px;
    opacity: 0.45;
    display: block;
    margin: 0 auto 4px;
}

.footer-line { font-size: 8.5px; color: #9ca3af; line-height: 1.55; }

</style>
</head>
<body>

@php
    // Always compute from items — never trust stale cached DB fields
    $subTotal    = $invoice->items->sum('line_total');
    $discount    = (float) ($invoice->discount ?? 0);
    $totalAmount = max(0, $subTotal - $discount);
    $depositPaid = (float) ($invoice->deposit_paid ?? 0);
    $balance     = max(0, $totalAmount - $depositPaid);
@endphp

<div class="brand-bar"></div>

<div class="wrap">

    {{-- Header --}}
    <table class="hdr">
        <tr>
            <td width="46%">
                @php
                    $badgeClass = match($invoice->status) {
                        'Overdue' => 'status-overdue',
                        'Draft'   => 'status-draft',
                        'Sent'    => 'status-sent',
                        default   => '',
                    };
                @endphp

                {{-- Title + status badge inline --}}
                <table style="border-collapse:collapse;margin-bottom:14px;">
                    <tr>
                        <td style="padding:0;vertical-align:middle;">
                            <div class="doc-type" style="margin-bottom:0;">INVOICE</div>
                        </td>
                        <td style="padding:0 0 0 10px;vertical-align:middle;">
                            <span class="status-badge {{ $badgeClass }}">{{ $invoice->status }}</span>
                        </td>
                    </tr>
                </table>

                {{-- Meta grid: 2 columns --}}
                <table style="border-collapse:collapse;width:100%;">
                    <tr>
                        <td style="padding:0 18px 9px 0;vertical-align:top;width:50%;">
                            <div class="meta-lbl">Invoice Number</div>
                            <div class="meta-val" style="margin-bottom:0;">{{ $invoice->invoice_id }}</div>
                        </td>
                        <td style="padding:0 0 9px;vertical-align:top;width:50%;">
                            <div class="meta-lbl">Date Issued</div>
                            <div class="meta-val" style="margin-bottom:0;">{{ $invoice->invoice_date?->format('d M Y') }}</div>
                        </td>
                    </tr>
                    @if($invoice->due_date || $invoice->job_id)
                    <tr>
                        @if($invoice->due_date)
                        <td style="padding:0 18px 0 0;vertical-align:top;width:50%;">
                            <div class="meta-lbl">Due Date</div>
                            <div class="meta-val" style="margin-bottom:0;{{ $invoice->status === 'Overdue' ? 'color:#dc2626;font-weight:700;' : '' }}">{{ $invoice->due_date->format('d M Y') }}</div>
                        </td>
                        @endif
                        @if($invoice->job_id)
                        <td style="padding:0;vertical-align:top;width:50%;">
                            <div class="meta-lbl">Job Reference</div>
                            <div class="meta-val" style="margin-bottom:0;">{{ $invoice->job_id }}</div>
                        </td>
                        @endif
                    </tr>
                    @endif
                </table>
            </td>
            <td width="54%" align="right">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" class="logo-img">
                @endif
                <div class="co">
                    <div class="co-name">{{ $business->business_name }}</div>
                    @if($business->street){{ $business->street }}<br>@endif
                    @if($business->city){{ $business->city }}@if($business->province), {{ $business->province }}@endif<br>@endif
                    @if($business->phone){{ $business->phone }}<br>@endif
                    @if($business->email){{ $business->email }}<br>@endif
                    @if($business->website){{ $business->website }}@endif
                    @if($business->vat_number)<br>VAT: {{ $business->vat_number }}@endif
                    @if($business->registration_number)<br>Reg: {{ $business->registration_number }}@endif
                </div>
            </td>
        </tr>
    </table>

    <hr class="section-divider">

    {{-- Bill To --}}
    <div class="section-lbl">Bill To</div>
    <div class="client-name">
        {{ $invoice->client?->company ?: trim(($invoice->client?->firstname ?? '') . ' ' . ($invoice->client?->lastname ?? '')) }}
    </div>
    @if($invoice->client?->company)
        <div class="client-line">{{ trim(($invoice->client->firstname ?? '') . ' ' . ($invoice->client->lastname ?? '')) }}</div>
    @endif
    @if($invoice->client?->street)
        <div class="client-line">{{ $invoice->client->street }}</div>
    @endif
    @if($invoice->client?->email)
        <div class="client-line">{{ $invoice->client->email }}</div>
    @endif
    @if($invoice->client?->phone_number)
        <div class="client-line">{{ $invoice->client->phone_number }}</div>
    @endif

    {{-- Line Items --}}
    <table class="tbl">
        <thead>
            <tr>
                <th>Service / Description</th>
                <th class="r" style="width:44px">Qty</th>
                <th class="r" style="width:106px">Unit Price</th>
                <th class="r" style="width:106px">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td class="r">{{ $item->quantity }}</td>
                <td class="r">R&nbsp;{{ number_format($item->unit_price, 2) }}</td>
                <td class="r">R&nbsp;{{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    <table class="totals">
        <tr class="sub">
            <td class="lc">Subtotal</td>
            <td>R&nbsp;{{ number_format($subTotal, 2) }}</td>
        </tr>
        @if($discount > 0)
        <tr class="disc">
            <td class="lc">Discount</td>
            <td>-R&nbsp;{{ number_format($discount, 2) }}</td>
        </tr>
        @endif
        <tr class="grand">
            <td class="lc">Invoice Total</td>
            <td>R&nbsp;{{ number_format($totalAmount, 2) }}</td>
        </tr>
        @if($depositPaid > 0)
        <tr class="dep">
            <td class="lc">Deposit Paid</td>
            <td>-R&nbsp;{{ number_format($depositPaid, 2) }}</td>
        </tr>
        <tr class="balance">
            <td class="lc">Balance Due</td>
            <td>R&nbsp;{{ number_format($balance, 2) }}</td>
        </tr>
        @endif
    </table>

    {{-- Client message / Notes --}}
    @if($invoice->client_message)
    <div class="card-wrap">
        <div class="notes-card">
            <div class="card-lbl">Note to Client</div>
            {{ $invoice->client_message }}
        </div>
    </div>
    @endif

    {{-- Payment Details --}}
    @if($business->bank_account_number)
    <div class="card-wrap">
        <div class="pay-card">
            <div class="card-lbl">EFT Payment Details</div>
            <table class="pay-tbl">
                @if($business->bank_name)
                <tr><td class="pk">Bank</td><td class="pv">{{ $business->bank_name }}</td></tr>
                @endif
                @if($business->bank_account_name)
                <tr><td class="pk">Account Holder</td><td class="pv">{{ $business->bank_account_name }}</td></tr>
                @endif
                <tr><td class="pk">Account Number</td><td class="pv">{{ $business->bank_account_number }}</td></tr>
                @if($business->bank_account_type)
                <tr><td class="pk">Account Type</td><td class="pv">{{ ucfirst($business->bank_account_type) }}</td></tr>
                @endif
                @if($business->bank_branch_code)
                <tr><td class="pk">Branch Code</td><td class="pv">{{ $business->bank_branch_code }}</td></tr>
                @endif
                @if($business->swift_code)
                <tr><td class="pk">SWIFT</td><td class="pv">{{ $business->swift_code }}</td></tr>
                @endif
                <tr><td class="pk">Reference</td><td class="ref">{{ $invoice->invoice_id }}</td></tr>
            </table>
            @if($business->payment_instructions)
            <p style="margin-top:8px;font-size:10px;color:#6b7280;">{{ $business->payment_instructions }}</p>
            @endif
        </div>
    </div>
    @endif

    {{-- Footer notes --}}
    @if($business->invoice_footer_notes)
    <div class="card-wrap">
        <div class="notes-card" style="border-left-color:#9ca3af;">
            <p style="font-size:10px;color:#6b7280;">{{ $business->invoice_footer_notes }}</p>
        </div>
    </div>
    @endif

    {{-- Footer — fixed to bottom of every page --}}
    <div class="footer">
        @php $lp = public_path('assets/images/logo/luminii_light.png'); @endphp
        @if(file_exists($lp))
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($lp)) }}" class="footer-logo">
        @endif
        <div class="footer-line">
            <strong style="color:#6b7280;">{{ $business->business_name }}</strong>
            @if($business->email)&nbsp;&middot;&nbsp;{{ $business->email }}@endif
            @if($business->website)&nbsp;&middot;&nbsp;{{ $business->website }}@endif
        </div>
        <div class="footer-line" style="color:#d1d5db;margin-top:2px;">
            Generated {{ now()->format('d M Y \a\t H:i') }}&nbsp;&middot;&nbsp;Computer generated document
        </div>
    </div>

</div>

</body>
</html>
