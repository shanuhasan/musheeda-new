<!DOCTYPE html>
<html>
<head>
    <title>Your E-Book Purchase from Musheeda Solutions</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-w-lg mx-auto p-4">
    <div style="text-align: center; margin-bottom: 20px;">
        <h1 style="color: #4F46E5;">Thank You For Your Purchase!</h1>
    </div>
    
    <p>Hi {{ $order->name }},</p>
    
    <p>We have successfully received your payment of ₹{{ $order->amount }} for the <strong>{{ $order->product_name }}</strong>.</p>
    
    <p>As promised, you will find your digital E-Book PDF attached to this email.</p>
    
    <div style="background-color: #f8fafc; padding: 15px; border-left: 4px solid #4F46E5; margin: 20px 0;">
        <h3 style="margin-top: 0;">Order Details:</h3>
        <p style="margin-bottom: 5px;"><strong>Order ID:</strong> {{ $order->razorpay_order_id }}</p>
        <p style="margin-bottom: 5px;"><strong>Payment ID:</strong> {{ $order->razorpay_payment_id }}</p>
        <p style="margin-bottom: 0;"><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
    </div>

    <p>If you have any questions or issues opening the file, please reply to this email and we'll be happy to assist you.</p>

    <p>Best regards,<br>
    <strong>Musheeda Solutions Team</strong></p>
</body>
</html>
