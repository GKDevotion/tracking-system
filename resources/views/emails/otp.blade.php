<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',sans-serif">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:40px 20px">
        <tr>
            <td align="center">
                <table width="520" cellpadding="0" cellspacing="0"
                       style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#3b82f6,#2563eb);padding:32px;text-align:center">
                            <div style="width:52px;height:52px;background:rgba(255,255,255,.2);border-radius:14px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:12px">
                                <span style="font-size:1.5rem">🔐</span>
                            </div>
                            <h1 style="margin:0;font-size:1.3rem;font-weight:700;color:#ffffff">
                                Password Reset OTP
                            </h1>
                            <p style="margin:6px 0 0;color:rgba(255,255,255,.75);font-size:.875rem">
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:36px 40px">
                            <p style="margin:0 0 16px;font-size:.95rem;color:#334155;line-height:1.6">
                                You requested a password reset. Use the OTP code below to verify your identity:
                            </p>

                            {{-- OTP Box --}}
                            <div style="text-align:center;margin:28px 0">
                                <div style="display:inline-block;background:#f0f9ff;border:2px dashed #3b82f6;border-radius:14px;padding:20px 40px">
                                    <p style="margin:0 0 6px;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#64748b">
                                        Your OTP Code
                                    </p>
                                    <p style="margin:0;font-size:2.5rem;font-weight:800;letter-spacing:.75rem;color:#1e40af;font-family:monospace">
                                        {{ $otp }}
                                    </p>
                                </div>
                            </div>

                            <p style="margin:0 0 12px;font-size:.875rem;color:#64748b;line-height:1.6">
                                ⏱ This code will expire in <strong>10 minutes</strong>.
                            </p>
                            <p style="margin:0;font-size:.875rem;color:#64748b;line-height:1.6">
                                If you did not request a password reset, please ignore this email. Your account remains safe.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:20px 40px;text-align:center">
                            <p style="margin:0;font-size:.75rem;color:#94a3b8">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
