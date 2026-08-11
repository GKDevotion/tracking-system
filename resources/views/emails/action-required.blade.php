<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Action Required — Wealthora Subscription</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f7;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f7;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="background:#ff4500;padding:24px 30px;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;">Wealthora Signal</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <p style="color:#222;font-size:16px;margin:0 0 16px;">
                                Dear {{ $checkout->first_name }},
                            </p>

                            <p style="color:#444;line-height:1.6;margin:0 0 16px;">
                                We are currently verifying your Wealthora subscription payment.
                            </p>

                            <p style="color:#444;line-height:1.6;margin:0 0 20px;">
                                We need a little additional information to complete the verification.
                            </p>

                            <p style="color:#222;margin:0 0 20px;">
                                <strong>Client ID:</strong> {{ $checkout->unique_id }}
                            </p>

                            <table cellpadding="0" cellspacing="0" width="100%"
                                   style="background:#fff8f5;border-left:4px solid #ff4500;border-radius:4px;margin:0 0 24px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="color:#222;margin:0 0 6px;font-weight:bold;">Required:</p>
                                        <p style="color:#444;line-height:1.6;margin:0;">
                                            {{ $checkout->admin_note }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#444;line-height:1.6;margin:0 0 20px;">
                                Please use the link below to update your payment details:
                            </p>

                            <p style="text-align:center;margin:0 0 24px;">
                                <a href="{{ $paymentUrl }}"
                                   style="background:#ff4500;color:#ffffff;text-decoration:none;padding:14px 28px;border-radius:6px;font-weight:bold;display:inline-block;">
                                    Update Payment Details
                                </a>
                            </p>

                            <p style="color:#888;font-size:13px;line-height:1.5;margin:0 0 24px;">
                                If the button doesn't work, copy and paste this link into your browser:<br>
                                <a href="{{ $paymentUrl }}" style="color:#ff4500;">{{ $paymentUrl }}</a>
                            </p>

                            <p style="color:#444;line-height:1.6;margin:0 0 16px;">
                                Once submitted, our Finance Team will continue the verification.
                            </p>

                            <p style="color:#444;line-height:1.6;margin:0 0 20px;">
                                Need assistance? Our support team will be happy to guide you.
                            </p>

                            <p style="color:#444;line-height:1.6;margin:0;">
                                Regards,<br>
                                <strong>Wealthora Signal Team</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 30px;background:#fafafa;color:#999;font-size:12px;">
                            © {{ date('Y') }} Wealthora Signal. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
