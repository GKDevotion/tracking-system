<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Details Received</title>
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
                            <h2 style="margin-top:0;color:#222;">Dear {{ $checkout->first_name }},</h2>

                            <p style="color:#2e7d32;font-weight:bold;line-height:1.6;font-size:16px;">
                                ✅ We have received your payment details successfully.
                            </p>

                            <table cellpadding="0" cellspacing="0" style="margin:20px 0;width:100%;">
                                <tr>
                                    <td style="padding:6px 0;color:#444;">
                                        <strong>Client ID:</strong>
                                        <span style="color:#ff4500;">{{ $checkout->unique_id }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;color:#444;">
                                        <strong>Plan:</strong>
                                        <strong>{{ $checkout->planDetails->name }}</strong>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#444;line-height:1.6;">
                                Your payment is now <strong>under verification by our Finance Team</strong>.
                            </p>

                            <p style="color:#444;line-height:1.6;">
                                No further action is required from you at this time.
                            </p>

                            <p style="color:#444;line-height:1.6;">
                                We will notify you by email once your payment has been verified.
                            </p>

                            <p style="color:#444;line-height:1.6;">
                                Thank you for your patience.
                            </p>

                            <p style="color:#444;line-height:1.6;margin-top:30px;">
                                Regards,<br>
                                <strong>Wealthora Signal Team</strong>
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