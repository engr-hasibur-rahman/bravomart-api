<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ com_option_get('com_site_title') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            padding: 40px 0;
        }
        .email-box {
            width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #4F46E5;
            padding: 20px;
            text-align: center;
        }
        .email-header img {
            max-height: 50px;
            margin-bottom: 10px;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
        }
        .email-body {
            padding: 30px;
            color: #333333;
        }
        .email-body p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555555;
        }
        .email-body p:last-child {
            margin-bottom: 0;
        }
        .footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999999;
        }
        .logo {
            text-align: center;
            padding: 20px 0;
            background-color: #ffffff;
        }
        .logo a {
            display: inline-block;
        }
        .logo img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="email-box">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="{{ com_option_get_id_wise_url(com_option_get('com_site_logo')) }}" alt="logo" width="200" height="auto">
            </a>
        </div>
        <div class="email-body">
            <p>
                {!! $data['body'] !!}
            </p>
        </div>
        <div class="footer">
            {{ com_get_footer_copyright() }}
        </div>
    </div>
</div>
</body>
</html>
