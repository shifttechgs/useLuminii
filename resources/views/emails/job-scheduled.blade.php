<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Kick-off Confirmed — {{ $business->business_name }}</title>
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
                        <div style="width:56px;height:56px;background:#e8f0ec;border-radius:50%;text-align:center;line-height:56px;font-size:24px;color:#1a3a2a;margin:0 auto 16px;">&#128640;</div>
                        <p style="margin:0 0 6px;font-size:22px;font-weight:700;color:#1c1917;letter-spacing:-0.3px;">We are ready to get started</p>
                        <p style="margin:0;font-size:14px;color:#78716c;">Hi {{ $job->client?->firstname ?? 'there' }}, your project has been scheduled and our team is ready to begin.</p>
                    </td>
                </tr>
            </table>

            {{-- Project details --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#faf9f7;border:1px solid #ede9e3;border-radius:8px;margin-bottom:28px;">
                <tr>
                    <td style="padding:20px 24px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td width="50%" style="padding-bottom:14px;">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Project</p>
                                    <p style="margin:0;font-size:13px;font-weight:600;color:#1c1917;">{{ $job->job_title }}</p>
                                </td>
                                <td width="50%" style="padding-bottom:14px;">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Reference</p>
                                    <p style="margin:0;font-size:13px;font-weight:600;color:#1c1917;font-family:monospace;">{{ $job->job_id }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Kick-off Date</p>
                                    <p style="margin:0;font-size:14px;font-weight:700;color:#1a3a2a;">{{ $job->job_date_time?->format('l, d M Y') }}</p>
                                    <p style="margin:2px 0 0;font-size:12px;color:#78716c;">{{ $job->job_date_time?->format('H:i') }}</p>
                                </td>
                                <td width="50%">
                                    <p style="margin:0 0 2px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.9px;color:#a8a29e;">Lead Developer</p>
                                    <p style="margin:0;font-size:13px;font-weight:600;color:#1c1917;">{{ $job->assignedTo?->name ?? $business->business_name }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- What happens next --}}
            <p style="margin:0 0 16px;font-size:13px;font-weight:700;color:#1c1917;text-transform:uppercase;letter-spacing:0.5px;">How we work</p>
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:28px;">
                <tr><td style="padding:0 0 14px;">
                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr>
                        <td width="32" valign="top"><div style="width:24px;height:24px;background:#1a3a2a;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:700;color:#ffffff;">1</div></td>
                        <td style="padding-left:12px;">
                            <p style="margin:0 0 2px;font-size:13px;font-weight:600;color:#1c1917;">Kick-off &amp; alignment</p>
                            <p style="margin:0;font-size:12px;color:#78716c;">We start by aligning on scope, goals, and priorities — making sure we are all working toward the same outcome.</p>
                        </td>
                    </tr></table>
                </td></tr>
                <tr><td style="padding:0 0 14px;">
                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr>
                        <td width="32" valign="top"><div style="width:24px;height:24px;background:#1a3a2a;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:700;color:#ffffff;">2</div></td>
                        <td style="padding-left:12px;">
                            <p style="margin:0 0 2px;font-size:13px;font-weight:600;color:#1c1917;">Regular updates throughout</p>
                            <p style="margin:0;font-size:12px;color:#78716c;">You will have full visibility into progress. We keep communication open and share updates at every key milestone.</p>
                        </td>
                    </tr></table>
                </td></tr>
                <tr><td>
                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr>
                        <td width="32" valign="top"><div style="width:24px;height:24px;background:#1a3a2a;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:700;color:#ffffff;">3</div></td>
                        <td style="padding-left:12px;">
                            <p style="margin:0 0 2px;font-size:13px;font-weight:600;color:#1c1917;">Delivery &amp; handover</p>
                            <p style="margin:0;font-size:12px;color:#78716c;">We do not just deliver code — we make sure everything is properly handed over, documented, and working as expected.</p>
                        </td>
                    </tr></table>
                </td></tr>
            </table>

            {{-- Sign-off --}}
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="padding-top:24px;border-top:1px solid #ede9e3;">
                <tr><td>
                    <p style="margin:0 0 12px;font-size:13px;color:#78716c;line-height:1.7;">We are genuinely excited to be working on this with you. If anything comes up before the kick-off or you have questions in the meantime, we are always a message away.</p>
                    <p style="margin:0 0 2px;font-size:13px;color:#78716c;">Warm regards,</p>
                    <p style="margin:0 0 6px;font-size:14px;font-weight:700;color:#1c1917;">{{ $business->business_name }}</p>
                    @if($business->email)<p style="margin:0 0 1px;font-size:12px;color:#a8a29e;">{{ $business->email }}</p>@endif
                    @if($business->phone)<p style="margin:0;font-size:12px;color:#a8a29e;">{{ $business->phone }}</p>@endif
                </td></tr>
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
