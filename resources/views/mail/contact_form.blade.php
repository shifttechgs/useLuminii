@php
    // Internal notification to the sales inbox for demo bookings and website enquiries.
    // Table layout + inline styles so it renders consistently in Gmail, Outlook and Apple Mail.
    $isDemo   = !empty($data['business_type']);
    $name     = trim($data['fullname'] ?? '') ?: 'Someone';
    $first    = strtok($name, ' ');
    $email    = $data['email'] ?? null;
    $kind     = $isDemo ? 'New demo request' : 'New website enquiry';
    $headline = $isDemo ? "{$name} wants a demo." : "{$name} sent an enquiry.";
    $context  = $isDemo
        ? collect([$data['business_type'] ?? null, $data['team_size'] ?? null])->filter()->implode(' · ')
        : ($data['package'] ?? null);
    $sentAt   = now()->setTimezone('Africa/Johannesburg')->format('D j M Y, H:i') . ' SAST';
    $replySubject = $isDemo ? 'Your useLuminii demo' : 'Your useLuminii enquiry';
    $replyHref = $email ? 'mailto:' . $email . '?subject=' . rawurlencode($replySubject) : null;
    // Embed the logo in the message so it shows without depending on the website or remote-image
    // settings; $message only exists when actually sending (browser previews fall back to the file URL).
    $logoPath = public_path('assets/images/logo/useluminii_logos/useluminii_light.png');
    $logo     = isset($message) ? $message->embed($logoPath) : asset('assets/images/logo/useluminii_logos/useluminii_light.png');
    $source   = !empty($data['source_page']) ? (parse_url($data['source_page'], PHP_URL_HOST) ?: 'the website') : 'the website';

    $details = array_filter([
        'Name'          => $name,
        'Email'         => $email,
        'Business type' => $data['business_type'] ?? null,
        'Team size'     => $data['team_size'] ?? null,
        'Plan'          => $data['package'] ?? null,
        'Current tools' => $data['current_tools'] ?? null,
    ], fn ($v) => filled($v));

    $focusLabel = $isDemo ? 'What they want to improve' : 'Their message';
    $focus      = $isDemo ? ($data['pain_point'] ?? null) : ($data['message'] ?? null);

    $navy = '#081D3A'; $gold = '#F5C542'; $mint = '#F2F6F5'; $muted = '#647082'; $faint = '#8490A3'; $rule = '#E5EAF2';
    $font = "'Inter Tight','Helvetica Neue',Helvetica,Arial,sans-serif";
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<title>{{ $kind }}: {{ $name }}</title>
<style>
    /* Mobile. The base layout is already fluid (100% up to 600px) and the buttons wrap on
       their own, so clients that ignore <style> still get a usable email. */
    @media only screen and (max-width: 600px) {
        .outer { padding: 16px 10px !important; }
        .px { padding-left: 20px !important; padding-right: 20px !important; }
        .hd { padding-top: 20px !important; padding-bottom: 20px !important; }
        .logo { width: 112px !important; }
        .h1 { font-size: 24px !important; line-height: 1.25 !important; }
        .ctx { font-size: 16px !important; }
        .btn { display: block !important; width: auto !important; margin: 0 0 10px !important; text-align: center !important; }
        .dt, .dd { display: block !important; width: auto !important; }
        .dt { padding: 12px 0 2px !important; border-bottom: 0 !important; }
        .dd { padding: 0 0 12px !important; }
    }
</style>
</head>
<body style="margin:0;padding:0;background:{{ $mint }};-webkit-text-size-adjust:100%;">
{{-- Inbox preview line (hidden in the body) --}}
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:{{ $mint }};">
    {{ $name }}{{ $context ? ' · ' . $context : '' }}{{ $focus ? ' · ' . \Illuminate\Support\Str::limit($focus, 80) : '' }}
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:{{ $mint }};">
<tr><td align="center" class="outer" style="padding:40px 16px;">

<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;">

    {{-- Header --}}
    <tr>
        <td class="px hd" style="background:{{ $navy }};border-radius:10px 10px 0 0;padding:24px 32px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" style="vertical-align:middle;">
                        <img src="{{ $logo }}" width="116" class="logo" alt="useLuminii" style="display:block;width:116px;height:auto;border:0;font-family:{{ $font }};font-size:18px;font-weight:600;color:#ffffff;">
                    </td>
                    <td align="right" style="vertical-align:middle;">
                        <span style="display:inline-block;padding:6px 10px;border-radius:999px;background:{{ $gold }};color:{{ $navy }};font-family:{{ $font }};font-size:12px;font-weight:600;letter-spacing:.2px;text-align:center;">{{ $kind }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Headline + actions --}}
    <tr>
        <td class="px" style="background:#ffffff;padding:34px 32px 8px;font-family:{{ $font }};">
            <p style="margin:0 0 10px;color:{{ $faint }};font-size:13px;">{{ $sentAt }}</p>
            <h1 class="h1" style="margin:0;color:{{ $navy }};font-size:28px;line-height:1.2;font-weight:600;letter-spacing:-.6px;">{{ $headline }}</h1>
            @if($context)
            <p class="ctx" style="margin:10px 0 0;color:{{ $muted }};font-size:17px;line-height:1.5;">{{ $context }}</p>
            @endif

            <div style="margin:28px 0 0;">
                @if($replyHref)
                <a href="{{ $replyHref }}" class="btn" style="display:inline-block;margin:0 8px 10px 0;padding:14px 24px;border-radius:999px;background:{{ $navy }};color:#ffffff;font-family:{{ $font }};font-size:15px;font-weight:600;line-height:1.2;text-decoration:none;">Reply to {{ $first }} &rarr;</a>
                @endif
                @if(!empty($data['crm_url']))
                <a href="{{ $data['crm_url'] }}" class="btn" style="display:inline-block;margin:0 0 10px;padding:13px 22px;border:1px solid #CBD5E4;border-radius:999px;color:{{ $navy }};font-family:{{ $font }};font-size:15px;font-weight:600;line-height:1.2;text-decoration:none;">Open in CRM</a>
                @endif
            </div>
        </td>
    </tr>

    {{-- Details --}}
    <tr>
        <td class="px" style="background:#ffffff;padding:18px 32px 4px;font-family:{{ $font }};">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid {{ $rule }};">
                @foreach($details as $label => $value)
                <tr>
                    <td class="dt" style="width:120px;padding:14px 0;border-bottom:1px solid {{ $rule }};color:{{ $faint }};font-size:13px;vertical-align:top;">{{ $label }}</td>
                    <td class="dd" style="padding:14px 0;border-bottom:1px solid {{ $rule }};color:{{ $navy }};font-size:15px;line-height:1.45;vertical-align:top;word-break:break-word;">
                        @if($label === 'Email')
                            <a href="mailto:{{ $value }}" style="color:{{ $navy }};text-decoration:underline;text-decoration-color:{{ $gold }};">{{ $value }}</a>
                        @else
                            {{ $value }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>

    {{-- What they want --}}
    @if(filled($focus))
    <tr>
        <td class="px" style="background:#ffffff;padding:24px 32px 8px;font-family:{{ $font }};">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="background:{{ $mint }};border-left:3px solid {{ $gold }};border-radius:0 8px 8px 0;padding:18px 20px;">
                        <p style="margin:0 0 6px;color:{{ $faint }};font-size:12px;letter-spacing:.6px;text-transform:uppercase;">{{ $focusLabel }}</p>
                        <p style="margin:0;color:{{ $navy }};font-size:17px;line-height:1.5;">{!! nl2br(e($focus)) !!}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif

    {{-- Next step --}}
    <tr>
        <td class="px" style="background:#ffffff;border-radius:0 0 10px 10px;padding:24px 32px 34px;font-family:{{ $font }};">
            <p style="margin:0;color:{{ $muted }};font-size:14px;line-height:1.6;">
                <strong style="color:{{ $navy }};">Next step:</strong>
                {{ $isDemo ? 'reply to confirm a demo time.' : 'reply to their enquiry.' }}
                @if(!empty($data['crm_url'])) This request is saved in the CRM. @endif
                Replying to this email goes straight to {{ $first }}.
            </p>
        </td>
    </tr>

    {{-- Footer --}}
    <tr>
        <td align="center" style="padding:22px 24px 0;font-family:{{ $font }};color:{{ $faint }};font-size:12px;line-height:1.6;">
            Sent from the {{ $isDemo ? 'demo booking form' : 'enquiry form' }} on {{ $source }}.<br>
            useLuminii, a product of ShiftTech.
        </td>
    </tr>

</table>
</td></tr>
</table>
</body>
</html>
