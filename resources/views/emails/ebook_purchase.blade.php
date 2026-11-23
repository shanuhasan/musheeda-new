<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your E-Book Purchase from Musheeda Solutions</title>
</head>
<body style="margin:0; padding:24px; background:#f8fafc; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width:560px; margin:0 auto; background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:28px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="color: #4F46E5; margin:0 0 4px;">Thank You For Your Purchase!</h1>
        </div>

        <p>Hi {{ $order->name }},</p>

        <p>We have successfully received your payment of ₹{{ number_format($order->amount, 2) }} for <strong>{{ $productTitle }}</strong>.</p>

        <p>Your e-book is attached to this email. You can also download it using the button below.</p>

        <p style="text-align:center; margin:28px 0;">
            <a href="{{ $downloadUrl }}" style="display:inline-block; background:#4F46E5; color:#ffffff; text-decoration:none; font-weight:bold; padding:12px 28px; border-radius:8px;">Download your e-book</a>
        </p>
        <p style="font-size:12px; color:#64748b; text-align:center; margin-top:-16px;">
            This link is valid for {{ $linkValidDays }} days.
        </p>

        <div style="background-color: #f8fafc; padding: 15px; border-left: 4px solid #4F46E5; margin: 20px 0;">
            <h3 style="margin-top: 0;">Order Details:</h3>
            <p style="margin-bottom: 5px;"><strong>Order ID:</strong> {{ $order->razorpay_order_id }}</p>
            <p style="margin-bottom: 5px;"><strong>Payment ID:</strong> {{ $order->razorpay_payment_id }}</p>
            <p style="margin-bottom: 0;"><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>

        <p>If you have any questions or issues opening the file, please reply to this email and we'll be happy to assist you.</p>

        <p>Best regards,<br>
        <strong>Musheeda Solutions Team</strong></p>
    </div>
</body>
</html>
