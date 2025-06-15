<?php
$allMet = true;
foreach ($folders as $key => $isWritable) {
    if (!$isWritable) {
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
</head>
<body>
<h1>Step 2: Get Your File Permissions Ready</h1>
<p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details Accurately</p>

<div class="steps">
    <a class="step" href="?step=welcome"></a>
    <a class="step" href="?step=requirements"></a>
    <a class="step active" href="?step=permissions"></a>
    <a class="step" href="?step=environment"></a>
    <a class="step"></a>
    <a class="step"></a>
</div>

<div class="card">
    <div class="grid">
        <?php foreach ($folders as $folder => $status): ?>
            <div class="permission-box"><span class="permission-name"><?= $folder ?></span><span
                        class="permission-status"><?= $status ? '&#10003;' : '&#10060;' ?></span></div>
        <?php endforeach; ?>
    </div>

    <div class="button-container">
        <p>All set with the permissions?</p>
        <a id="nextBtnPermissions"
                class="button"
                href="<?= $allMet ? '?step=permissions' : '#' ?>"
                data-all-met="<?= $allMet ? '1' : '0' ?>">
                Next
            </a>
    </div>
</div>
<script src="assets/js/toast.js"></script>
        <script>
            const nextBtn = document.getElementById('nextBtnPermissions');

            nextBtn?.addEventListener('click', function(e) {
                const allMet = this.dataset.allMet === '1';

                if (!allMet) {
                    e.preventDefault();
                    showToast("Please give all the neccessary permissions to procceed further.");
                }
            });
        </script>
</body>
</html>
