<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Installation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Inter, sans-serif;
            background-color: #002366;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 60px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 100px;
            display: flex;
            justify-content: space-between;
            align-items: stretch; /* Make both children equal height */
            gap: 20px;
        }

        .left, .right {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-top: 40px;
            font-size: 32px;
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

        .info-boxes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 500px;
            margin: auto;
        }

        .info-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
        }

        .info-box .icon {
            display: block;
            margin: 0 auto 4px auto;
            width: 125px; /* Adjust this size as needed */
            height: auto;
        }

        .info-box .label {
            font-weight: bold;
            font-size: 16px;
        }


        .right {
            display: flex;
            flex-direction: column; /* Stack children vertically */
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }


        .right img {
            width: 100%;
            max-width: 300px;
        }

        .right .cta {
            text-align: center;
            margin-top: 20px;
        }

        .cta a.button {
            display: inline-block;
            background-color: #1A73E8;
            color: #fff;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-size: large;
            font-weight: normal;
        }

        .cta a.source {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: underline;
            font-size: 14px;
        }
    </style>
</head>
<body>

<h1>System Installation</h1>
<p class="subtitle">Follow the step-by-step instructions and input the required details accurately</p>

<div class="steps">
    <a class="step active" href="?step=welcome"></a>
    <a class="step" href="?step=requirements"></a>
    <div class="step"></div>
    <div class="step"></div>
    <div class="step"></div>
</div>

<div class="container">
    <div class="left">
        <h2>Database Setup Information</h2>
        <p>Ensure the following information is ready before installation. It’s required to complete the process.</p>
        <div class="info-boxes">
            <div class="info-box">
                <img class="icon" src="assets/images/database.svg"
                     alt="Install Illustration">
                <div class="label">Database Name</div>
            </div>
            <div class="info-box">
                <img class="icon" src="assets/images/database_user_name.svg"
                     alt="Install Illustration">
                <div class="label">Database Username</div>
            </div>
            <div class="info-box">
                <img class="icon" src="assets/images/database_host_name.svg"
                     alt="Install Illustration">
                <div class="label">Database Host Name</div>
            </div>
            <div class="info-box">
                <img class="icon" src="assets/images/database_password.svg"
                     alt="Install Illustration">
                <div class="label">Database Password</div>
            </div>
        </div>
    </div>
    <div class="right">
        <img src="assets/images/ready_to_begin.png"
             alt="Install Illustration">
        <div class="cta">
            <p>Ready to begin the installation?</p>
            <a class="button" href="?step=requirements">Get Started</a>
            <a class="source" href="#">Required Information Source?</a>
        </div>
    </div>
</div>

</body>
</html>




