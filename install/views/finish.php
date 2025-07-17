<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Complete</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/install/assets/css/style.css" rel="stylesheet">
</head>
<body>
<h1>Step 6: Installation Complete</h1>
<p class="subtitle">Your system is now ready to use</p>

<div class="steps">
    <a class="step"></a>
    <a class="step"></a>
    <a class="step"></a>
    <a class="step"></a>
    <a class="step"></a>
    <a class="step active"></a>
</div>

<div class="card">
    <div class="success-message">
        <img src="/install/assets/images/finish.svg" alt="finish">
        Installation Completed Successfully
    </div>

    <div class="options-container">
        <a href="<?= $frontendUrl ?>" target="_blank" class="option-item blue">
            <span class="option-name">Landing Page</span>
        </a>

        <a href="<?= $adminUrl ?>" target="_blank" class="option-item deep-blue">
            <span class="option-name">Admin Panel</span>
        </a>
    </div>
</div>
</body>
</html>