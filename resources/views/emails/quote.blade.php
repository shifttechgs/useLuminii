<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quotation {{ $quote->quote_id }} — {{ $business->business_name }}</title>
</head>
<body style="margin:0;padding:0;background:#f5f3ef;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f5f3ef;padding:44px 16px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;width:100%;">

    {{-- Top bar --}}
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
                Dear {{ $quote->client?->firstname ?? 'Valued Client' }},
            </p>
            <p style="margin:0 0 28px;font-size:14px;color:#78716c;line-height:1.75;">
                Thank you for considering us. We have prepared a quotation for
                <span style="color:#1c1917;font-weight:600;">{{ $quote->job_title }}</span>
                and attached it to this email as a PDF. A summary is included below.
            </p>

            {{-- Quote meta strip --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="background:#faf9f7;border:1px solid #ede9e3;border-radius:8px;margin-bottom:24px;">
                <tr>
                    <td width="33%" style="padding:16px 20px;border-right:1px solid #ede9e3;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Quote No.</p>
                        <p style="margin:0;font-size:12.5px;font-weight:700;color:#1c1917;font-family:monospace;">{{ $quote->quote_id }}</p>
                    </td>
                    <td width="33%" style="padding:16px 20px;border-right:1px solid #ede9e3;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Issued</p>
                        <p style="margin:0;font-size:12.5px;font-weight:600;color:#1c1917;">{{ $quote->quote_date?->format('d M Y') }}</p>
                    </td>
                    <td width="33%" style="padding:16px 20px;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Valid Until</p>
                        <p style="margin:0;font-size:12.5px;font-weight:600;color:#1c1917;">
                            {{ $quote->expiry_date ? $quote->expiry_date->format('d M Y') : '—' }}
                        </p>
                    </td>
                </tr>
            </table>

            {{-- Line items --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="border-radius:8px;overflow:hidden;border:1px solid #ede9e3;margin-bottom:6px;">
                <tr>
                    <th align="left"  style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;">Description</th>
                    <th align="right" style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;width:36px;">Qty</th>
                    <th align="right" style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;width:88px;">Unit</th>
                    <th align="right" style="background:#1a3a2a;padding:10px 16px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#ffffff;width:88px;">Total</th>
                </tr>
                @foreach($quote->items as $i => $item)
                <tr style="background:{{ $i % 2 === 0 ? '#ffffff' : '#faf9f7' }}">
                    <td style="padding:10px 16px;font-size:13px;color:#44403c;border-bottom:1px solid #f3f0eb;">{{ $item->description }}</td>
                    <td align="right" style="padding:10px 16px;font-size:13px;color:#78716c;border-bottom:1px solid #f3f0eb;">{{ $item->quantity }}</td>
                    <td align="right" style="padding:10px 16px;font-size:13px;color:#78716c;border-bottom:1px solid #f3f0eb;">R&nbsp;{{ number_format($item->unit_price, 2) }}</td>
                    <td align="right" style="padding:10px 16px;font-size:13px;font-weight:600;color:#1c1917;border-bottom:1px solid #f3f0eb;">R&nbsp;{{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach

                {{-- Subtotal / discount --}}
                @if($quote->discount > 0)
                <tr>
                    <td colspan="3" align="right" style="padding:10px 16px 4px;font-size:12px;color:#78716c;">Subtotal</td>
                    <td align="right" style="padding:10px 16px 4px;font-size:12px;color:#78716c;">R&nbsp;{{ number_format($quote->sub_total, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" align="right" style="padding:2px 16px 8px;font-size:12px;color:#16a34a;">Discount</td>
                    <td align="right" style="padding:2px 16px 8px;font-size:12px;color:#16a34a;">&minus;R&nbsp;{{ number_format($quote->discount, 2) }}</td>
                </tr>
                @endif

                {{-- Grand total --}}
                <tr style="background:#1a3a2a;">
                    <td colspan="3" align="right" style="padding:13px 16px;font-size:13px;font-weight:700;color:#ffffff;">Grand Total</td>
                    <td align="right" style="padding:13px 16px;font-size:15px;font-weight:700;color:#ffffff;">R&nbsp;{{ number_format($quote->grand_total, 2) }}</td>
                </tr>
            </table>

            {{-- Deposit --}}
            @if($quote->required_deposit > 0)
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:10px;">
                <tr>
                    <td style="background:#fffbeb;border-left:3px solid #f59e0b;padding:10px 14px;border-radius:0 5px 5px 0;">
                        <p style="margin:0;font-size:12px;color:#92400e;line-height:1.5;">
                            A deposit of <strong>R {{ number_format($quote->required_deposit, 2) }}</strong> is required to confirm this booking.
                        </p>
                    </td>
                </tr>
            </table>
            @endif

            {{-- Client notes --}}
            @if($quote->client_notes)
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:10px;">
                <tr>
                    <td style="background:#faf9f7;border-left:3px solid #1a3a2a;padding:10px 14px;border-radius:0 5px 5px 0;">
                        <p style="margin:0 0 3px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;color:#a8a29e;">Note</p>
                        <p style="margin:0;font-size:13px;color:#44403c;line-height:1.6;">{{ $quote->client_notes }}</p>
                    </td>
                </tr>
            </table>
            @endif

            {{-- CTA --}}
            @if($quote->accepted_token)
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:32px;">
                <tr>
                    <td align="center">
                        <a href="{{ url('/client-hub/quote/' . $quote->accepted_token) }}"
                           style="display:inline-block;background:#1a3a2a;color:#ffffff;text-decoration:none;font-size:14px;font-weight:600;padding:14px 40px;border-radius:6px;letter-spacing:0.1px;">
                            View &amp; Accept Quote
                        </a>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-top:10px;">
                        <p style="margin:0;font-size:11px;color:#a8a29e;">Or simply reply to this email — we are always happy to help.</p>
                    </td>
                </tr>
            </table>
            @endif

            {{-- Sign-off --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:36px;padding-top:24px;border-top:1px solid #ede9e3;">
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
                <br>The PDF quotation is attached to this email for your records.
            </p>
        </td>
    </tr>

    {{-- Bottom bar --}}
    <tr>
        <td style="background:#1a3a2a;height:3px;border-radius:0 0 6px 6px;font-size:0;line-height:0;">&nbsp;</td>
    </tr>

</table>
</td></tr>
</table>

</body>
</html>
