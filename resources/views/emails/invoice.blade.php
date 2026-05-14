<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice {{ $invoice->invoice_id }} — {{ $business->business_name }}</title>
</head>
<body style="margin:0;padding:0;background:#f5f3ef;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;">

@php
    // Always compute from items — never trust stale cached DB fields
    $subTotal    = $invoice->items->sum('line_total');
    $discount    = (float) ($invoice->discount ?? 0);
    $totalAmount = max(0, $subTotal - $discount);
    $depositPaid = (float) ($invoice->deposit_paid ?? 0);
    $balance     = max(0, $totalAmount - $depositPaid);
@endphp

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f5f3ef;padding:44px 16px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;width:100%;">

    {{-- Top accent bar --}}
    <tr>
        <td style="background:#1a3a2a;height:4px;border-radius:6px 6px 0 0;font-size:0;line-height:0;">&nbsp;</td>
    </tr>

    {{-- Logo / brand header --}}
    <tr>
        <td align="center" style="background:#ffffff;padding:32px 48px 24px;border-bottom:1px solid #ede9e3;">
            @if(!empty($logoUrl))
                <img src="{{ $logoUrl }}" alt="{{ $business->business_name }}" style="max-height:42px;max-width:180px;display:block;margin:0 auto 10px;">
            @else
                <p style="margin:0;font-size:17px;font-weight:700;color:#1a3a2a;letter-spacing:-0.3px;">{{ $business->business_name }}</p>
            @endif
            @if($business->website)
            <p style="margin:4px 0 0;font-size:11px;color:#a8a29e;letter-spacing:0.3px;">{{ $business->website }}</p>
            @endif
        </td>
    </tr>

    {{-- Body --}}
    <tr>
        <td style="background:#ffffff;padding:36px 48px 40px;">

            {{-- Greeting --}}
            <p style="margin:0 0 8px;font-size:16px;font-weight:600;color:#1c1917;">
                Dear {{ $invoice->client?->firstname ?? 'Valued Client' }},
            </p>
            <p style="margin:0 0 28px;font-size:14px;color:#78716c;line-height:1.75;">
                Please find attached your invoice from
                <span style="color:#1c1917;font-weight:600;">{{ $business->business_name }}</span>.
                @if($invoice->due_date)
                    Payment is due by <span style="color:#1c1917;font-weight:600;">{{ $invoice->due_date->format('d M Y') }}</span>.
                @endif
            </p>

            {{-- Overdue banner --}}
            @if($invoice->status === 'Overdue')
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:20px;">
                <tr>
                    <td style="background:#fef2f2;border-left:3px solid #ef4444;padding:12px 16px;border-radius:0 5px 5px 0;">
                        <p style="margin:0;font-size:13px;color:#991b1b;line-height:1.5;">
                            <strong>&#9888; This invoice is overdue.</strong>
                            Please make payment as soon as possible to avoid disruption of services.
                        </p>
                    </td>
                </tr>
            </table>
            @endif

            {{-- Invoice meta strip --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="background:#faf9f7;border:1px solid #ede9e3;border-radius:8px;margin-bottom:24px;">
                <tr>
                    <td width="33%" style="padding:16px 20px;border-right:1px solid #ede9e3;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Invoice No.</p>
                        <p style="margin:0;font-size:12.5px;font-weight:700;color:#1c1917;font-family:monospace;">{{ $invoice->invoice_id }}</p>
                    </td>
                    <td width="33%" style="padding:16px 20px;border-right:1px solid #ede9e3;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Issued</p>
                        <p style="margin:0;font-size:12.5px;font-weight:600;color:#1c1917;">{{ $invoice->invoice_date?->format('d M Y') }}</p>
                    </td>
                    <td width="33%" style="padding:16px 20px;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Due Date</p>
                        <p style="margin:0;font-size:12.5px;font-weight:600;color:{{ $invoice->status === 'Overdue' ? '#dc2626' : '#1c1917' }};">
                            {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '—' }}
                        </p>
                    </td>
                </tr>
            </table>

            {{-- Line items --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="border-radius:8px;overflow:hidden;border:1px solid #ede9e3;margin-bottom:6px;">
                <tr>
                    <th align="left"  style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;">Service / Description</th>
                    <th align="right" style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;width:36px;">Qty</th>
                    <th align="right" style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;width:88px;">Unit</th>
                    <th align="right" style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;width:88px;">Total</th>
                </tr>
                @foreach($invoice->items as $i => $item)
                <tr style="background:{{ $i % 2 === 0 ? '#ffffff' : '#faf9f7' }}">
                    <td style="padding:10px 16px;font-size:13px;color:#44403c;border-bottom:1px solid #f3f0eb;">{{ $item->description }}</td>
                    <td align="right" style="padding:10px 16px;font-size:13px;color:#78716c;border-bottom:1px solid #f3f0eb;">{{ $item->quantity }}</td>
                    <td align="right" style="padding:10px 16px;font-size:13px;color:#78716c;border-bottom:1px solid #f3f0eb;">R&nbsp;{{ number_format($item->unit_price, 2) }}</td>
                    <td align="right" style="padding:10px 16px;font-size:13px;font-weight:600;color:#1c1917;border-bottom:1px solid #f3f0eb;">R&nbsp;{{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach

                {{-- Subtotal / Discount rows --}}
                @if($discount > 0)
                <tr>
                    <td colspan="3" align="right" style="padding:10px 16px 4px;font-size:12px;color:#78716c;">Subtotal</td>
                    <td align="right" style="padding:10px 16px 4px;font-size:12px;color:#78716c;">R&nbsp;{{ number_format($subTotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" align="right" style="padding:2px 16px 8px;font-size:12px;color:#16a34a;">Discount</td>
                    <td align="right" style="padding:2px 16px 8px;font-size:12px;color:#16a34a;">&minus;R&nbsp;{{ number_format($discount, 2) }}</td>
                </tr>
                @endif

                {{-- Invoice total row --}}
                <tr style="background:#1a3a2a;">
                    <td colspan="3" align="right" style="padding:13px 16px;font-size:13px;font-weight:700;color:#ffffff;">Invoice Total</td>
                    <td align="right" style="padding:13px 16px;font-size:15px;font-weight:700;color:#ffffff;">R&nbsp;{{ number_format($totalAmount, 2) }}</td>
                </tr>
            </table>

            {{-- Deposit paid & balance due --}}
            @if($depositPaid > 0)
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:8px;">
                <tr>
                    <td style="background:#fffbeb;border-left:3px solid #f59e0b;padding:10px 14px;border-radius:0 5px 5px 0;">
                        <p style="margin:0;font-size:12px;color:#92400e;line-height:1.6;">
                            Deposit paid: <strong>R&nbsp;{{ number_format($depositPaid, 2) }}</strong>
                            &nbsp;&nbsp;&middot;&nbsp;&nbsp;
                            <strong style="font-size:13px;">Balance due: R&nbsp;{{ number_format($balance, 2) }}</strong>
                        </p>
                    </td>
                </tr>
            </table>
            @endif

            {{-- Client message --}}
            @if($invoice->client_message)
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:12px;">
                <tr>
                    <td style="background:#faf9f7;border-left:3px solid #1a3a2a;padding:10px 14px;border-radius:0 5px 5px 0;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#a8a29e;">Note</p>
                        <p style="margin:0;font-size:13px;color:#44403c;line-height:1.6;">{{ $invoice->client_message }}</p>
                    </td>
                </tr>
            </table>
            @endif

            {{-- EFT banking details --}}
            @if($business->bank_account_number)
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="margin-top:28px;background:#1a3a2a;border-radius:8px;">
                <tr>
                    <td style="padding:20px 24px;">
                        <p style="margin:0 0 14px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:rgba(255,255,255,0.5);">EFT Payment Details</p>
                        <table width="100%" cellpadding="0" cellspacing="0">
                            @if($business->bank_name)
                            <tr>
                                <td style="padding:5px 0;font-size:12px;color:rgba(255,255,255,0.5);width:150px;">Bank</td>
                                <td style="padding:5px 0;font-size:12px;color:#ffffff;font-weight:500;">{{ $business->bank_name }}</td>
                            </tr>
                            @endif
                            @if($business->bank_account_name)
                            <tr>
                                <td style="padding:5px 0;font-size:12px;color:rgba(255,255,255,0.5);width:150px;">Account Name</td>
                                <td style="padding:5px 0;font-size:12px;color:#ffffff;font-weight:500;">{{ $business->bank_account_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="padding:5px 0;font-size:12px;color:rgba(255,255,255,0.5);width:150px;">Account Number</td>
                                <td style="padding:5px 0;font-size:12px;color:#ffffff;font-weight:500;">{{ $business->bank_account_number }}</td>
                            </tr>
                            @if($business->bank_account_type)
                            <tr>
                                <td style="padding:5px 0;font-size:12px;color:rgba(255,255,255,0.5);width:150px;">Account Type</td>
                                <td style="padding:5px 0;font-size:12px;color:#ffffff;font-weight:500;">{{ ucfirst($business->bank_account_type) }}</td>
                            </tr>
                            @endif
                            @if($business->bank_branch_code)
                            <tr>
                                <td style="padding:5px 0;font-size:12px;color:rgba(255,255,255,0.5);width:150px;">Branch Code</td>
                                <td style="padding:5px 0;font-size:12px;color:#ffffff;font-weight:500;">{{ $business->bank_branch_code }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="padding:8px 0 0;font-size:12px;color:rgba(255,255,255,0.5);width:150px;">Reference</td>
                                <td style="padding:8px 0 0;font-size:14px;color:#fbbf24;font-weight:700;">{{ $invoice->invoice_id }}</td>
                            </tr>
                        </table>
                        @if($business->payment_instructions)
                        <p style="margin:12px 0 0;font-size:11px;color:rgba(255,255,255,0.4);line-height:1.6;">{{ $business->payment_instructions }}</p>
                        @endif
                    </td>
                </tr>
            </table>
            @endif

            {{-- CTA --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:32px;">
                <tr>
                    <td align="center">
                        <a href="{{ url('/client-hub/invoice/' . $invoice->view_token) }}"
                           style="display:inline-block;background:#1a3a2a;color:#ffffff;text-decoration:none;font-size:14px;font-weight:600;padding:14px 40px;border-radius:6px;letter-spacing:0.1px;">
                            View Invoice Online
                        </a>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-top:10px;">
                        <p style="margin:0;font-size:11px;color:#a8a29e;">Or simply reply to this email — we are always happy to help.</p>
                    </td>
                </tr>
            </table>

            {{-- Sign-off --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="margin-top:36px;padding-top:24px;border-top:1px solid #ede9e3;">
                <tr>
                    <td>
                        <p style="margin:0 0 12px;font-size:13px;color:#78716c;line-height:1.6;">
                            We look forward to working with you. Please do not hesitate to reach out if you have any questions or would like to discuss anything further.
                        </p>
                        <p style="margin:0 0 2px;font-size:13px;color:#78716c;">Warm regards,</p>
                        <p style="margin:0 0 6px;font-size:14px;font-weight:700;color:#1c1917;">{{ $business->business_name }}</p>
                        @if($business->email)
                        <p style="margin:0 0 1px;font-size:12px;color:#a8a29e;">{{ $business->email }}</p>
                        @endif
                        @if($business->phone)
                        <p style="margin:0 0 1px;font-size:12px;color:#a8a29e;">{{ $business->phone }}</p>
                        @endif
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    {{-- Footer --}}
    <tr>
        <td style="background:#faf9f7;border-top:1px solid #ede9e3;padding:20px 48px;text-align:center;border-radius:0 0 6px 6px;">
            <p style="margin:0;font-size:11px;color:#a8a29e;line-height:1.7;">
                &copy; {{ date('Y') }} {{ $business->business_name }}.
                @if($business->vat_number) &middot; VAT: {{ $business->vat_number }}@endif
                @if($business->registration_number) &middot; Reg: {{ $business->registration_number }}@endif
                <br>The PDF invoice is attached to this email for your records.
            </p>
        </td>
    </tr>

    {{-- Bottom accent bar --}}
    <tr>
        <td style="background:#1a3a2a;height:3px;border-radius:0 0 6px 6px;font-size:0;line-height:0;">&nbsp;</td>
    </tr>

</table>
</td></tr>
</table>

</body>
</html>
