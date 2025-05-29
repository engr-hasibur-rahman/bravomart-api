<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Step 1</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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

        .card {
            background-color: #fff;
            border-radius: 10px;
            max-width: 1200px;
            margin: 60px auto;
            padding: 100px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .permission-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 2px solid #f0f0f0;
            transition: 0.3s;
        }

        .permission-box:hover {
            border-color: #c3d3f7;
        }

        .permission-name {
            font-weight: 600;
        }

        .permission-status {
            color: #4CAF50;
            font-size: 18px;
        }

        .button-container {
            margin-top: 40px;
            text-align: center;
        }

        .button-container p {
            margin-bottom: 12px;
        }

        .button-container .button {
            background-color: #1A73E8;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>
<body>
<h1>Step 1: Get Your File Permissions Ready</h1>
<p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details Accurately</p>

<div class="steps">
    <a class="step" href="?step=welcome"></a>
    <a class="step" href="?step=requirements"></a>
    <a class="step active" href="?step=permissions"></a>
    <a class="step" href="?step=environment"></a>
    <div class="step"></div>
</div>

<div class="card">
    <div class="grid">
        <?php foreach ($folders as $folder => $status): ?>
            <div class="permission-box"><span class="permission-name"><?= $folder ?></span><span
                        class="permission-status"><?= $status ? '&#10003;' : '&#10060;' ?></span></div>
        <?php endforeach; ?>
        <!--        <div class="permission-box"><span class="permission-name">Observer Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Repository Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Service Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Json Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Mbstring Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Openssl Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Xml Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Zip Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Tokenizer Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Intervention Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">File Info Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Pdo Mysql Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">RouteServiceProvider.Php File</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Storage Enabled</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">.Env File Permission</span><span class="permission-status">&#10003;</span></div>-->
        <!--        <div class="permission-box"><span class="permission-name">Helper Enabled</span><span class="permission-status">&#10003;</span></div>-->
    </div>

    <div class="button-container">
        <p>All set with the permissions?</p>
        <a href="?step=environment" class="button">Get Started</a>
    </div>
</div>
</body>
</html>
