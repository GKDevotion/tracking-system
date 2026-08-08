<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Pricing Plan Registration</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f5f7; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f5f7; padding:30px 0;">
        <tr>
            <td align="center">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.06);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#000; padding:28px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="color:#ffffff; font-size:20px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
                                        New Pricing Plan Registration
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Intro line -->
                    <tr>
                        <td style="padding:24px 32px 8px 32px; font-family: Arial, Helvetica, sans-serif; color:#4a5568; font-size:14px; line-height:20px;">
                            A new checkout registration has been submitted. Details are below.
                        </td>
                    </tr>

                    <!-- Details table -->
                    <tr>
                        <td style="padding:16px 32px 32px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; font-family: Arial, Helvetica, sans-serif; font-size:14px;">

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; width:40%; color:#6b7280; font-weight:bold;">Full Name</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">{{ $checkout->full_name }}</td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; color:#6b7280; font-weight:bold;">Email</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">{{ $checkout->email }}</td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; color:#6b7280; font-weight:bold;">Phone</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">{{ $checkout->mobile_number }}</td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; color:#6b7280; font-weight:bold;">Country</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">{{ $checkout->countryData?->name ?? 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; color:#6b7280; font-weight:bold;">Plan</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">
                                        @switch($checkout->plan)
                                            @case(0)
                                                <span style="display:inline-block; padding:4px 10px; background-color:#e6f4ea; color:#1e7e34; border-radius:4px; font-size:12px; font-weight:bold;">Basic</span>
                                            @break

                                            @case(1)
                                                <span style="display:inline-block; padding:4px 10px; background-color:#fff4e5; color:#b45309; border-radius:4px; font-size:12px; font-weight:bold;">Advanced</span>
                                            @break

                                            @case(2)
                                                <span style="display:inline-block; padding:4px 10px; background-color:#e8eaf6; color:#3730a3; border-radius:4px; font-size:12px; font-weight:bold;">Institutional</span>
                                            @break
                                        @endswitch
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; color:#6b7280; font-weight:bold;">Telegram Username</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">{{ $checkout->tele_username }}</td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; color:#6b7280; font-weight:bold;">Trade Signals</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">{{ $checkout->trade_signals == 0 ? 'Telegram' : 'WhatsApp' }}</td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; background-color:#f7f8fa; border:1px solid #e5e8ec; color:#6b7280; font-weight:bold;">Payment Type</td>
                                    <td style="padding:12px 16px; background-color:#ffffff; border:1px solid #e5e8ec; color:#000;">{{ $checkout->payment_type }}</td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f7f8fa; padding:18px 32px; border-top:1px solid #e5e8ec; font-family: Arial, Helvetica, sans-serif; font-size:12px; color:#9aa1ab; text-align:center;">
                            This is an automated notification. Please do not reply to this email.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
