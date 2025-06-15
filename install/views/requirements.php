<?php
$allMet = true;
foreach ($requirements['extensions'] as $key => $isLoaded) {
    if (!$isLoaded) {
        $allMet = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Step 1</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/toast.css" rel="stylesheet">
    <?php include 'views/partials/toast.php'; ?>
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


        .button-container p {
            margin-bottom: 12px;
        }

        .button-container .button {
            max-width: 250px;
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
    <h1>Step 1: Get Your File Requirements Ready</h1>
    <p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details Accurately</p>

    <div class="steps">
        <a class="step" href="?step=welcome"></a>
        <a class="step active" href="?step=requirements"></a>
        <a class="step"  href="?step=permissions"></a>
        <a class="step"></a>
        <a class="step"></a>
        <a class="step"></a>
    </div>

    <div class="card">
        <div class="grid">
            <?php foreach ($requirements['extensions'] as $ext => $status): ?>
                <div class="permission-box"><span class="permission-name"><?= strtoupper($ext) ?></span><span
                        class="permission-status"><?= $status ? '&#10003;' : '&#10060;' ?></span></div>
            <?php endforeach; ?>
        </div>

        <div class="button-container">
            <p>All set with the permissions?</p>
            <a id="nextBtn"
                class="button"
                href="<?= $allMet ? '?step=permissions' : '#' ?>"
                data-all-met="<?= $allMet ? '1' : '0' ?>">
                Get Started
            </a>
        </div>
        <script src="assets/js/toast.js"></script>
        <script>
            const nextBtn = document.getElementById('nextBtn');

            nextBtn?.addEventListener('click', function(e) {
                const allMet = this.dataset.allMet === '1';

                if (!allMet) {
                    e.preventDefault();
                    showToast("Please enable all required extensions to proceed.");
                }
            });
        </script>
</body>

</html>