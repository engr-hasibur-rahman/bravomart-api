<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sharp Mart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #0d6efd;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Sharp Mart</h1>
    </div>

    <!-- Email Body -->
    <h2 style="text-align: center; color: #333;">Welcome to Sharp Mart!</h2>
    <p>Thank you for subscribing to our newsletter. We're excited to share the latest updates, exclusive offers, and promotions with you!</p>

    <p>Get ready to explore:</p>
    <ul>
        <li>Exclusive Discounts</li>
        <li>New Arrivals</li>
        <li>Special Offers Just for You</li>
    </ul>

    <!-- Action Button -->
    <div style="text-align: center;">
        <a href="{{ url('/') }}" class="button">Start Shopping</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© {{ date('Y') }} Sharp Mart. All rights reserved.</p>
    </div>
</div>

</body>
</html>
