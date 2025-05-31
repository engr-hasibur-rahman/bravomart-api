<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Complete</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #002366;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #fff;
            font-size: 28px;
            margin-top: 40px;
        }

        p.subtitle {
            text-align: center;
            color: #ddd;
            margin-bottom: 20px;
        }

        .steps {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .step {
            width: 50px;
            height: 20px;
            background-color: #89a7e0;
            margin: 0 5px;
            border-radius: 10px;
        }

        .step.active {
            background-color: #fff;
        }

        .configuration-title {
            color: #444;
            font-size: 22px;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .success-message {
            height: 340px;
            width: 55%;
            font-size: x-large;
            color: #252525;
            font-weight: 600;
            margin: 30px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 30px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .success-message img {
            height: 80px;
            width: 80px;
        }

        .options-container {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            gap: 15px;
            margin: 40px 0;
            width: 35%;
        }

        .option-item {
            text-align: center;
            height: 50px;
            width: 200px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .blue {
            background-color: #1868D1;
        }

        .deep-blue {
            background-color: #10458B;
        }

        .option-name {
            font-weight: 600;
        }

        .checkmark {
            width: 20px;
            height: 20px;
        }

        .continue-btn {
            background-color: #1A73E8;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
            text-decoration: none;
        }

        .continue-btn:hover {
            background-color: #0d5bba;
        }

        @media (max-width: 768px) {
            .card {
                padding: 30px;
                margin: 30px 20px;
            }
        }
    </style>
</head>
<body>
<h1>Step 5: Installation Complete</h1>
<p class="subtitle">Your system is now ready to use</p>

<div class="steps">
    <a class="step" href="?step=welcome"></a>
    <a class="step" href="?step=requirements"></a>
    <a class="step" href="?step=permissions"></a>
    <a class="step" href="?step=environment"></a>
    <a class="step" href="?step=admin"></a>
    <a class="step active" href="?step=finish"></a>
</div>

<div class="card">
    <div class="success-message">
        <img src="assets/images/finish.svg" alt="finish">
        Installation Completed Successfully
    </div>

    <div class="options-container">
        <div class="option-item blue">
            <span class="option-name">Landing Page</span>
        </div>

        <div class="option-item deep-blue">
            <span class="option-name">Admin Panel</span>
        </div>
    </div>
</div>
</body>
</html>