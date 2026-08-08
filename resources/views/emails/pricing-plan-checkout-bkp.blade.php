<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>

    <h2>New Pricing Plan Registration</h2>

    <table cellpadding="8" cellspacing="0" border="1">
        <tr>
            <th>Full Name</th>
            <td>{{ $checkout->full_name }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $checkout->email }}</td>
        </tr>

        <tr>
            <th>Country</th>
            <td>{{ $checkout->country }}</td>
        </tr>

        <tr>
            <th>Plan</th>
            <td>
                @switch($checkout->plan)
                    @case(0)
                        Basic
                    @break

                    @case(1)
                        Advanced
                    @break

                    @case(2)
                        Institutional
                    @break
                @endswitch
            </td>
        </tr>

        <tr>
            <th>Phone</th>
            <td>{{ $checkout->mobile_number }}</td>
        </tr>

        <tr>
            <th>Telegram Username</th>
            <td>{{ $checkout->tele_username }}</td>
        </tr>

        <tr>
            <th>Trade Signals</th>
            <td>{{ $checkout->trade_signals == 0 ? 'Telegram' : 'WhatsApp' }}</td>
        </tr>

        <tr>
            <th>Payment Type</th>
            <td>{{ $checkout->payment_type }}</td>
        </tr>

    </table>

</body>

</html>
