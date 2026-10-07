<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#0d1730;font-family:'DM Sans',Arial,sans-serif;color:#e8ecf5;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr><td align="center" style="padding:40px 20px;">
            <table role="presentation" width="100%" style="max-width:480px;background:#151f3d;border-radius:16px;padding:36px 28px;">
                <tr><td align="center" style="padding-bottom:20px;">
                    <div style="width:170px;aspect-ratio:1;border:4px double #e0505f;border-radius:50%;display:inline-flex;flex-direction:column;align-items:center;justify-content:center;color:#e0505f;font-weight:800;">
                        <span style="font-size:11px;letter-spacing:1px;">YOUR PLACE IS</span>
                        <strong style="font-size:22px;margin:4px 0;">{{ $result['name'] }}</strong>
                        <span style="font-size:11px;letter-spacing:1px;">{{ $result['match'] }}% MATCH</span>
                    </div>
                </td></tr>
                <tr><td align="center">
                    <h1 style="font-size:22px;margin:0 0 10px;color:#fff;">You belong in {{ $result['name'] }}</h1>
                    <p style="font-size:15px;line-height:1.6;color:#c5cee3;margin:0 0 24px;">{{ $result['tagline'] }}</p>
                    <p style="font-size:13px;color:#93a0bd;margin:0;">Sent to you from the Passport Lounge Manila quiz.</p>
                </td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>