<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quote Approved — {{ $business->business_name }}</title>
</head>
<body style="margin:0;padding:0;background:#f5f3ef;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f5f3ef;padding:44px 16px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;width:100%;">

    <tr><td style="background:#1a3a2a;height:4px;border-radius:6px 6px 0 0;font-size:0;line-height:0;">&nbsp;</td></tr>

    {{-- Logo --}}
    <tr>
        <td align="center" style="background:#ffffff;padding:32px 48px 24px;border-bottom:1px solid #ede9e3;">
            @if(!empty($logoUrl))
                <img src="{{ $logoUrl }}" alt="{{ $business->business_name }}" style="max-height:42px;max-width:180px;display:block;margin:0 auto 10px;">
            @else
                <p style="margin:0;font-size:17px;font-weight:700;color:#1a3a2a;">{{ $business->business_name }}</p>
            @endif
            @if($business->website)
            <p style="margin:4px 0 0;font-size:11px;color:#a8a29e;">{{ $business->website }}</p>
            @endif
        </td>
    </tr>

    {{-- Body --}}
    <tr>
        <td style="background:#ffffff;padding:40px 48px;">

            {{-- Icon + heading --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:28px;">
                <tr>
                    <td align="center">
                        <div style="width:56px;height:56px;background:#e8f0ec;border-radius:50%;text-align:center;line-height:56px;font-size:26px;color:#1a3a2a;margin:0 auto 16px;font-weight:700;">&#10003;</div>
                        <p style="margin:0 0 6px;font-size:22px;font-weight:700;color:#1c1917;letter-spacing:-0.3px;">You're confirmed!</p>
                        <p style="margin:0;font-size:14px;color:#78716c;">Thank you for approving your quote, {{ $quote->client?->firstname ?? 'there' }}.</p>
                    </td>
                </tr>
            </table>

            {{-- Quote summary --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#faf9f7;border:1px solid #ede9e3;border-radius:8px;margin-bottom:28px;">
                <tr>
                    <td style="padding:20px 24px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td width="50%" style="padding-bottom:10px;">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Project</p>
                                    <p style="margin:0;font-size:13px;font-weight:600;color:#1c1917;">{{ $quote->job_title }}</p>
                                </td>
                                <td width="50%" style="padding-bottom:10px;">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Quote No.</p>
                                    <p style="margin:0;font-size:13px;font-weight:600;color:#1c1917;font-family:monospace;">{{ $quote->quote_id }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Approved On</p>
                                    <p style="margin:0;font-size:13px;font-weight:600;color:#1c1917;">{{ $quote->accepted_at?->format('d M Y') }}</p>
                                </td>
                                <td width="50%">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Total Value</p>
                                    <p style="margin:0;font-size:14px;font-weight:700;color:#1a3a2a;">R&nbsp;{{ number_format($quote->grand_total, 2) }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- What happens next --}}
            <p style="margin:0 0 16px;font-size:13px;font-weight:700;color:#1c1917;text-transform:uppercase;letter-spacing:0.5px;">What happens next</p>
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:28px;">
                <tr>
                    <td style="padding:0 0 14px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td width="32" valign="top">
                                    <div style="width:24px;height:24px;background:#1a3a2a;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:700;color:#ffffff;">1</div>
                                </td>
                                <td style="padding-left:12px;">
                                    <p style="margin:0 0 2px;font-size:13px;font-weight:600;color:#1c1917;">We schedule your project kick-off</p>
                                    <p style="margin:0;font-size:12px;color:#78716c;">Your approval has been recorded. We will be in touch shortly to confirm a kick-off date.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 0 14px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td width="32" valign="top">
                                    <div style="width:24px;height:24px;background:#1a3a2a;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:700;color:#ffffff;">2</div>
                                </td>
                                <td style="padding-left:12px;">
                                    <p style="margin:0 0 2px;font-size:13px;font-weight:600;color:#1c1917;">Discovery &amp; planning</p>
                                    <p style="margin:0;font-size:12px;color:#78716c;">We align on requirements, timelines, and deliverables so development starts on a solid foundation.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td width="32" valign="top">
                                    <div style="width:24px;height:24px;background:#1a3a2a;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:700;color:#ffffff;">3</div>
                                </td>
                                <td style="padding-left:12px;">
                                    <p style="margin:0 0 2px;font-size:13px;font-weight:600;color:#1c1917;">Development &amp; delivery</p>
                                    <p style="margin:0;font-size:12px;color:#78716c;">We build, test, and deliver. You have full visibility throughout — no black boxes, no surprises.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- Deposit note --}}
            @if($quote->required_deposit > 0)
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:28px;">
                <tr>
                    <td style="background:#fffbeb;border-left:3px solid #f59e0b;padding:12px 16px;border-radius:0 6px 6px 0;">
                        <p style="margin:0;font-size:12px;color:#92400e;line-height:1.6;">
                            A deposit of <strong>R&nbsp;{{ number_format($quote->required_deposit, 2) }}</strong> is required to confirm your booking.
                            Please use <strong>{{ $quote->quote_id }}</strong> as your payment reference.
                        </p>
                    </td>
                </tr>
            </table>
            @endif

            {{-- Sign-off --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="padding-top:24px;border-top:1px solid #ede9e3;">
                <tr>
                    <td>
                        <p style="margin:0 0 12px;font-size:13px;color:#78716c;line-height:1.7;">
                            We are genuinely excited to build this with you. If you have any questions before the kick-off, we are always a message away.
                        </p>
                        <p style="margin:0 0 2px;font-size:13px;color:#78716c;">Warm regards,</p>
                        <p style="margin:0 0 6px;font-size:14px;font-weight:700;color:#1c1917;">{{ $business->business_name }}</p>
                        @if($business->email)<p style="margin:0 0 1px;font-size:12px;color:#a8a29e;">{{ $business->email }}</p>@endif
                        @if($business->phone)<p style="margin:0;font-size:12px;color:#a8a29e;">{{ $business->phone }}</p>@endif
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    {{-- Footer --}}
    <tr>
        <td style="background:#faf9f7;border-top:1px solid #ede9e3;padding:18px 48px;text-align:center;border-radius:0 0 6px 6px;">
            <p style="margin:0;font-size:11px;color:#a8a29e;line-height:1.6;">
                &copy; {{ date('Y') }} {{ $business->business_name }}.
                @if($business->vat_number) &middot; VAT: {{ $business->vat_number }}@endif
            </p>
        </td>
    </tr>

    <tr><td style="background:#1a3a2a;height:3px;border-radius:0 0 6px 6px;font-size:0;line-height:0;">&nbsp;</td></tr>

</table>
</td></tr>
</table>

</body>
</html>
