<h1>Booking Confirmed</h1>
<p>Dear {{ $booking->first_name }},</p>
<p>Your booking with code <strong>{{ $booking->code }}</strong> has been confirmed. Thank you for your payment.</p>
<p>Details:</p>
<ul>
    <li>Booking Code: {{ $booking->code }}</li>
    <li>Total: ${{ $booking->total }}</li>
    <li>Status: {{ $booking->status }}</li>
</ul>
