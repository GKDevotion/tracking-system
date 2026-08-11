<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thanks for signing up — Wealthora Signal</title>
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
                            <h2 style="margin-top:0;color:#222;">Hi {{ $checkout->first_name }},</h2>

                            <p style="color:#444;line-height:1.6;margin-bottom:20px;">
                                Thank you for choosing <strong>Wealthora Signal</strong>.
                                Your registration has been received successfully.
                            </p>

                            {{-- Order summary --}}
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="background:#f8f9fa;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <table width="100%" cellpadding="6" cellspacing="0" style="font-size:14px;color:#333;">
                                            <tr>
                                                <td style="color:#888;width:40%;">Plan</td>
                                                <td style="font-weight:bold;">{{ $checkout->plan->name }}</td>
                                            </tr>
                                            @if($checkout->plan_amount > 0)
                                            <tr>
                                                <td style="color:#888;">Amount</td>
                                                <td style="font-weight:bold;">${{ number_format($checkout->plan_amount, 2) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="color:#888;">Order ID</td>
                                                <td style="font-weight:bold;color:#ff4500;">{{ $checkout->unique_id }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if($paymentUrl)
                                <p style="color:#444;line-height:1.6;">
                                    Please use the button below to complete your payment:
                                </p>

                                <p style="text-align:center;margin:26px 0;">
                                    <a href="{{ $paymentUrl }}"
                                       style="background:#ff4500;color:#ffffff;text-decoration:none;padding:14px 28px;border-radius:6px;font-weight:bold;display:inline-block;">
                                        Complete Payment
                                    </a>
                                </p>

                                <p style="color:#888;font-size:13px;line-height:1.5;margin-bottom:24px;">
                                    If the button doesn't work, copy and paste this link into your browser:<br>
                                    <a href="{{ $paymentUrl }}" style="color:#ff4500;">{{ $paymentUrl }}</a>
                                </p>

                                <p style="color:#444;line-height:1.6;">
                                    After making the payment, please <strong>upload your payment receipt</strong>
                                    on that page to complete the final submission.
                                </p>
                            @else
                                <p style="color:#444;line-height:1.6;">
                                    Your free plan is active. Welcome aboard!
                                </p>
                            @endif

                            <p style="color:#444;line-height:1.6;margin-top:24px;">
                                If you need any assistance, simply contact our support team at
                                <a href="mailto:support@wealthora.io" style="color:#ff4500;">support@wealthora.io</a>.
                            </p>

                            <p style="color:#444;line-height:1.6;margin-top:24px;margin-bottom:0;">
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