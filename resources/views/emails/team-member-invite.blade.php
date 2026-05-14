<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Invitation</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f8fafc; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #635bff 0%, #4f46e5 100%); padding: 36px 40px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.5px; }
        .header p { color: rgba(255,255,255,0.75); margin: 6px 0 0; font-size: 14px; }
        .body { padding: 36px 40px; }
        .body p { color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 16px; }
        .cred-box { background: #f1f5f9; border-radius: 10px; padding: 20px 24px; margin: 24px 0; border-left: 4px solid #635bff; }
        .cred-box p { margin: 4px 0; font-size: 14px; color: #475569; }
        .cred-box strong { color: #1e293b; }
        .btn { display: block; text-align: center; margin: 24px 0; }
        .btn a { background: #635bff; color: white; text-decoration: none; padding: 14px 32px; border-radius: 10px; font-weight: 600; font-size: 15px; display: inline-block; }
        .footer { padding: 24px 40px; border-top: 1px solid #f1f5f9; text-align: center; }
        .footer p { color: #94a3b8; font-size: 12px; margin: 0; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="header">
            <h1>🎉 You're invited!</h1>
            <p>Luminii CRM — Team Invitation</p>
        </div>
        <div class="body">
            <p>Hi <strong>{{ $inviteeName }}</strong>,</p>
            <p>You've been invited to join <strong>{{ $businessName }}</strong> on Luminii CRM as a <strong>{{ $role }}</strong>.</p>
            <p>Here are your login credentials. Please change your password after first login.</p>
            <div class="cred-box">
                <p>🔗 <strong>Login URL:</strong> {{ $loginUrl }}</p>
                <p>🔑 <strong>Temporary Password:</strong> {{ $tempPassword }}</p>
            </div>
            <div class="btn">
                <a href="{{ $loginUrl }}">Access Luminii CRM →</a>
            </div>
            <p style="font-size:13px;color:#94a3b8;">If you did not expect this invitation, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            <p>Luminii CRM · ShiftTech · shifttechgs.com</p>
        </div>
    </div>
</div>
</body>
</html>

