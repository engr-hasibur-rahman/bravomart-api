<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .email-header p {
            font-size: 16px;
            color: #777;
            margin-bottom: 0;
        }
        .email-content {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }
        .email-footer {
            text-align: center;
            padding-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .highlight {
            font-weight: bold;
            color: #ff6347;
        }
        .cta-button {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h5>Hello {{ $deliveryman_name }}</h5>
        <p>We have an important update for you.</p>
    </div>

    <div class="email-content">
        <p>We are happy to inform you that you have received a new earning of <span class="highlight">${{ $amount }}</span>.</p>
        <p>Order ID: <span class="highlight">{{ $order_id }}</span></p>
        <p>Order Amount: <span class="highlight">${{ $order_amount }}</span></p>
        <p>Your new order has arrived, and we are grateful for your hard work!</p>
        <a href="#" class="cta-button">View Order Details</a>
    </div>

    <div class="email-footer">
        <p>Thank you for being a valuable member of our team!</p>
        <p>If you have any questions, please contact us at <a href="mailto:support@example.com">support@example.com</a>.</p>
    </div>
</div>
</body>
</html>
