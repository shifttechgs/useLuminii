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
.totals tr.sub td  { padding-top: 10px; color: #374151; }
.totals tr.disc td { color: #16a34a; }
.totals tr.grand td {
    padding-top: 8px;
    padding-bottom: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    border-top: 1.5px solid #d1d5db;
}
.totals tr.dep td { font-size: 10.5px; color: #b45309; font-weight: 700; }

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

/* ── Disclaimer ──────────────────────────────────────────── */
.disc-box {
    margin-top: 14px;
    padding: 8px 12px;
    background: #fffbeb;
    border-left: 3px solid #f59e0b;
    font-size: 10px;
    color: #92400e;
    line-height: 1.55;
    page-break-inside: avoid;
}

/* ── Accept ──────────────────────────────────────────────── */
.accept-card {
    margin-top: 12px;
    padding: 9px 12px;
    background: #f0f9ff;
    border-left: 3px solid #0ea5e9;
    font-size: 10.5px;
    color: #0c4a6e;
    line-height: 1.65;
    page-break-inside: avoid;
}

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

<div class="brand-bar"></div>

<div class="wrap">

    {{-- Header --}}
    <table class="hdr">
        <tr>
            <td width="46%">
                <div class="doc-type">QUOTATION</div>
                <div class="meta-lbl">Quote Number</div>
                <div class="meta-val">{{ $quote->quote_id }}</div>
                <div class="meta-lbl">Date Issued</div>
                <div class="meta-val">{{ $quote->quote_date?->format('d M Y') }}</div>
                @if($quote->expiry_date)
                <div class="meta-lbl">Valid Until</div>
                <div class="meta-val">{{ $quote->expiry_date->format('d M Y') }}</div>
                @endif
            </td>
            <td width="54%" align="right">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" class="logo-img">
                @endif
                <div class="co">
                    <div class="co-name">{{ $business->business_name }}</div>
                    @if($business->street){{ $business->street }}<br>@endif
                    @if($business->city){{ $business->city }}@if($business->province), {{ $business->province }}@endif<br>@endif
                    @if($business->phone){{ $business->phone }}<br>@endif
                    @if($business->email){{ $business->email }}<br>@endif
                    @if($business->website){{ $business->website }}@endif
                </div>
            </td>
        </tr>
    </table>

    <hr class="section-divider">

    {{-- Bill To --}}
    <div class="section-lbl">Bill To</div>
    <div class="client-name">
        {{ $quote->client?->company ?: trim($quote->client?->firstname . ' ' . $quote->client?->lastname) }}
    </div>
    @if($quote->client?->company)
        <div class="client-line">{{ trim($quote->client->firstname . ' ' . $quote->client->lastname) }}</div>
    @endif
    @if($quote->client?->street)
        <div class="client-line">{{ $quote->client->street }}</div>
    @endif
    @if($quote->client?->email)
        <div class="client-line">{{ $quote->client->email }}</div>
    @endif
    @if($quote->client?->phone_number)
        <div class="client-line">{{ $quote->client->phone_number }}</div>
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
            @foreach($quote->items as $item)
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
            <td>R&nbsp;{{ number_format($quote->sub_total, 2) }}</td>
        </tr>
        @if($quote->discount > 0)
        <tr class="disc">
            <td class="lc">Discount</td>
            <td>&#8722;R&nbsp;{{ number_format($quote->discount, 2) }}</td>
        </tr>
        @endif
        <tr class="grand">
            <td class="lc">Total</td>
            <td>R&nbsp;{{ number_format($quote->grand_total, 2) }}</td>
        </tr>
        @if($quote->required_deposit > 0)
        <tr class="dep">
            <td class="lc">Required Deposit</td>
            <td>R&nbsp;{{ number_format($quote->required_deposit, 2) }}</td>
        </tr>
        @endif
    </table>

    {{-- Notes --}}
    @if($quote->client_notes)
    <div class="card-wrap">
        <div class="notes-card">
            <div class="card-lbl">Notes</div>
            {{ $quote->client_notes }}
        </div>
    </div>
    @endif

    {{-- Payment Details --}}
    @if($business->bank_account_number)
    <div class="card-wrap">
        <div class="pay-card">
            <div class="card-lbl">Payment Details</div>
            <table class="pay-tbl">
                @if($business->bank_name)
                <tr><td class="pk">Bank</td><td class="pv">{{ $business->bank_name }}</td></tr>
                @endif
                <tr><td class="pk">Account Number</td><td class="pv">{{ $business->bank_account_number }}</td></tr>
                @if($business->bank_account_name)
                <tr><td class="pk">Account Holder</td><td class="pv">{{ $business->bank_account_name }}</td></tr>
                @endif
                @if($business->bank_account_type)
                <tr><td class="pk">Account Type</td><td class="pv">{{ ucfirst($business->bank_account_type) }}</td></tr>
                @endif
                @if($business->bank_branch_code)
                <tr><td class="pk">Branch Code</td><td class="pv">{{ $business->bank_branch_code }}</td></tr>
                @endif
            </table>
        </div>
    </div>
    @endif

    {{-- Disclaimer --}}
    @if($quote->expiry_date)
    <div class="disc-box">
        <strong>Disclaimer:</strong>
        This quotation is valid until <strong>{{ $quote->expiry_date->format('d M Y') }}</strong>.
        Prices are subject to change after this date.
    </div>
    @endif

    {{-- Accept link --}}
    @if($quote->accepted_token && $quote->status === 'Sent')
    <div class="accept-card">
        <strong>How to Accept This Quote</strong><br>
        Visit: {{ url('/client-hub/quote/' . $quote->accepted_token) }}<br>
        Or reply to this email confirming your acceptance.
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
        <div class="footer-line" style="color:#d1d5db; margin-top:2px;">
            Generated {{ now()->format('d M Y \a\t H:i') }}&nbsp;&middot;&nbsp;Computer generated document
        </div>
    </div>

</div>

</body>
</html>
