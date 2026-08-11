<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment received</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f7;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f7;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="background:#ff4500;padding:24px 30px;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;">Wealthora</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <h2 style="margin-top:0;color:#222;">Hi {{ $checkout->first_name }},</h2>

                            <p style="color:#444;line-height:1.6;">
                                We've received your payment proof for reference
                                <strong style="color:#ff4500;">{{ $checkout->unique_id }}</strong>.
                            </p>

                            <p style="color:#444;line-height:1.6;">
                                Our team will verify it and activate your plan within 1–2 hours.
                                We'll notify you as soon as it's confirmed.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 30px;background:#fafafa;color:#999;font-size:12px;">
                            © {{ date('Y') }} Wealthora. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
