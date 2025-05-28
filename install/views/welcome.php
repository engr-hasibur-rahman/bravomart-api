<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Installation</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #002366;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 60px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left, .right {
            width: 48%;
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
        }

        .info-box {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            color: #fff;
        }

        .green { background-color: #28a745; }
        .blue { background-color: #007bff; }
        .orange { background-color: #fd7e14; }
        .purple { background-color: #6f42c1; }

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
            background-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
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
    <div class="step active"></div>
    <div class="step"></div>
    <div class="step"></div>
    <div class="step"></div>
    <div class="step"></div>
</div>

<div class="container">
    <div class="left">
        <h2>Database Setup Information</h2>
        <p>Ensure the following information is ready before installation. It’s required to complete the process.</p>
        <div class="info-boxes">
            <div class="info-box green">Database Name</div>
            <div class="info-box blue">Database Username</div>
            <div class="info-box orange">Database Host Name</div>
            <div class="info-box purple">Database Password</div>
        </div>
    </div>

    <div class="right">
        <img src="https://cdni.iconscout.com/illustration/premium/thumb/software-installation-6771357-5627174.png" alt="Install Illustration">
        <div class="cta">
            <p>Ready to begin the installation?</p>
            <a class="button" href="?step=requirements">Get Started</a>
            <a class="source" href="#">Required Information Source?</a>
        </div>
    </div>
</div>

</body>
</html>


