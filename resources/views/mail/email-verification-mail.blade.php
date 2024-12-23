<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body>
<h1>Hello, {{ $customer->first_name }}!</h1>
<p>We have received a request to verify your email address. Here is your verification code:</p>

<h1> {{ $customer->email_verify_token }}!</h1>

<p>If you did not request this, please ignore this email.</p>
</body>
</html>
