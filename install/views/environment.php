<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Database Setup</title>
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

        h2 {
            color: #444;
            font-size: 22px;
            margin-bottom: 30px;
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

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        .form-group input {
            width: 100%;
            height: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1A73E8;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1A73E8;
        }

        .divider {
            height: 1px;
            background-color: #eee;
            margin: 30px 0;
        }
        .button-container {
            margin-top: 40px;
            text-align: center;
        }

        .submit-btn {
            text-align: center;
            background-color: #1A73E8;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 25%;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
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
<h1>Step 3: Enter Database Information</h1>
<p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details For Database Accurately</p>

<div class="steps">
    <a class="step" href="?step=welcome"></a>
    <a class="step" href="?step=requirements"></a>
    <a class="step" href="?step=permissions"></a>
    <a class="step active" href="?step=environment"></a>
    <a class="step" href="?step=admin"></a>
</div>

<div class="card">
    <h2>Provide your database information</h2>
    <form method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="app_name">App Name</label>
                <input type="text" id="app_name" name="app_name" placeholder="Bravo Mart" required>
            </div>
            <div class="form-group">
                <label for="db_host">Database Host</label>
                <input type="text" id="db_host" name="db_host" placeholder="Localhost" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="db_port">Database Port</label>
                <input type="text" id="db_port" name="db_port" placeholder="3306" required>
            </div>

            <div class="form-group">
                <label for="db_database">Database Name</label>
                <input type="text" id="db_database" name="db_database" placeholder="Project-name-db" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="db_username">Database Username</label>
                <input type="text" id="db_username" name="db_username" placeholder="root" required>
            </div>

            <div class="form-group">
                <label for="db_password">Database Password</label>
                <input type="password" id="db_password">
            </div>
        </div>

        <div class="button-container">
            <button type="submit" class="submit-btn">Complete Installation</button>
        </div>
    </form>
</div>
</body>
</html>
