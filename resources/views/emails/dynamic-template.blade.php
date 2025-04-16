<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{com_option_get('com_site_title').' '. __('Mail')}}</title>
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
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
        }

        .email-body h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .email-body ul {
            list-style-type: none;
            padding-left: 0;
            font-size: 16px;
            line-height: 1.6;
        }

        .email-body ul li {
            margin-bottom: 6px;
        }

        .email-body p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555555;
            line-height: 1.6;
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

        /* RTL Specific Styles */
        [dir="rtl"] .email-header h1 {
            text-align: right;
        }
        [dir="rtl"] .email-body p {
            text-align: right;
        }
        [dir="rtl"] .footer {
            text-align: right;
        }

        /* Media Queries for Responsiveness */
        @media screen and (max-width: 600px) {
            .email-box {
                width: 100% !important;
                padding: 10px;
            }
            .email-header h1 {
                font-size: 18px !important;
            }
            .email-body p {
                font-size: 14px !important;
            }
            .footer {
                font-size: 10px !important;
                padding: 15px;
            }
            .logo img {
                max-width: 150px !important;
            }
        }
    </style>
</head>
<body>
<div class="container">
     <div class="email-box">
        <div class="logo">
            <a href="{{url('/')}}">
                {!! com_option_get_id_wise_url(com_option_get('com_site_logo')) !!}
            </a>
        </div>
        <div class="email-body">
            {!! $data !!}
        </div>
        <footer>
            {!! com_get_footer_copyright() !!}
        </footer>
    </div>
</div>
</body>
</html>
