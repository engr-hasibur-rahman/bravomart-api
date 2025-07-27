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
    <link href="/install/assets/css/style.css" rel="stylesheet">
    <link href="/install/assets/css/toast.css" rel="stylesheet">
    <?php include __DIR__ . '/partials/toast.php'; ?>
    <style>
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

    </style>
</head>

<body>
    <h1>Step 2: Get Your File Requirements Ready</h1>
    <p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details Accurately</p>

    <div class="steps">
        <a class="step"></a>
        <a class="step active"></a>
        <a class="step"></a>
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
        <script src="/install/assets/js/toast.js"></script>
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