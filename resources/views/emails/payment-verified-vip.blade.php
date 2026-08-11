<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Wealthora VIP</title>
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
                                ✅ Your payment has been successfully verified and your Wealthora VIP subscription is now active.
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
                                        <strong>Plan:</strong> {{ $checkout->planDetails->name }}
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td style="padding:6px 0;color:#444;">
                                        <strong>Start Date:</strong> {{ optional($checkout->start_date)->format('d M Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;color:#444;">
                                        <strong>Expiry Date:</strong> {{ optional($checkout->expiry_date)->format('d M Y') }}
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td style="padding:6px 0;color:#444;">
                                        <strong>Subscription Status:</strong>
                                        <span style="color:#2e7d32;font-weight:bold;">Active</span>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#444;line-height:1.6;">
                                You can now access your VIP signal service using the link below:
                            </p>

                            <p style="text-align:center;margin:28px 0;">
                                <a href="{{ $checkout->vip_access_link }}"
                                   style="background:#ff4500;color:#ffffff;text-decoration:none;padding:14px 28px;border-radius:6px;font-weight:bold;display:inline-block;">
                                    Access Wealthora VIP →
                                </a>
                            </p>

                            <p style="color:#444;line-height:1.6;">
                                Before following your first signal, please review our
                                <strong>Lot Size &amp; Risk Management Guide</strong> and always consider your
                                account size, Stop Loss distance, and personal risk tolerance before entering a trade.
                                Please remember that trading involves risk, and no trading signal can guarantee a profit.
                            </p>

                            <p style="color:#444;line-height:1.6;">
                                If you need any assistance with VIP access or our signal service, our support team
                                will be happy to guide you.
                            </p>

                            <p style="color:#444;line-height:1.6;font-weight:bold;margin-top:20px;">
                                Welcome to Wealthora VIP.<br>
                                Trade smart. Stay disciplined. Grow with Wealthora Signal.
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