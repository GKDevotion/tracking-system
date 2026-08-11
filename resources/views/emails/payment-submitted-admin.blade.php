<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Payment proof submitted</title></head>
<body style="font-family:Arial,Helvetica,sans-serif;color:#222;">
    <h2>Payment proof submitted — {{ $checkout->unique_id }}</h2>

    <table cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
        <tr><td><strong>Name</strong></td><td>{{ $checkout->full_name }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $checkout->email }}</td></tr>
        <tr><td><strong>Phone</strong></td><td>{{ $checkout->mobile_number }}</td></tr>
        <tr><td><strong>Country</strong></td><td>{{ $checkout->country }}</td></tr>
        <tr><td><strong>Plan</strong></td><td>{{ $checkout->plan }}</td></tr>
        <tr><td><strong>Payment type</strong></td><td>{{ $checkout->payment_type }}</td></tr>
        <tr>
            <td><strong>Payment option</strong></td>
            <td>
                @if($checkout->payment_option === 0) USDT - TRC20
                @elseif($checkout->payment_option === 1) USDT - BEP20
                @elseif($checkout->payment_option === 2) Bank Transfer
                @endif
            </td>
        </tr>
        <tr><td><strong>Submitted at</strong></td><td>{{ $checkout->payment_submitted_at }}</td></tr>
    </table>

    <p>Payment proof is attached to this email.</p>
</body>
</html>
