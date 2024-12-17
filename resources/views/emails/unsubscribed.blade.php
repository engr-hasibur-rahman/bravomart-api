<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscription Confirmation - Sharp Mart</title>
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
            background-color: #ff4b5c;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .button {
            display: inline-block;
            background-color: #ff4b5c;
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
    <h2 style="text-align: center; color: #333;">Unsubscription Confirmed</h2>
    <p>We're sorry to see you go. Your unsubscription from the Sharp Mart newsletter has been successfully processed.</p>

    <p>We value your time and hope you'll consider joining us again in the future to enjoy:</p>
    <ul>
        <li>Exclusive Discounts</li>
        <li>Exciting New Arrivals</li>
        <li>Special Offers</li>
    </ul>

    <!-- Optional CTA Button to Resubscribe -->
    <div style="text-align: center;">
        <a href="{{ url('/subscribe') }}" class="button">Subscribe again</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© {{ date('Y') }} Sharp Mart. All rights reserved.</p>
    </div>
</div>

</body>
</html>
