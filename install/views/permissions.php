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
    <link href="/install/assets/css/style.css" rel="stylesheet">
    <link href="/install/assets/css/toast.css" rel="stylesheet">
    <?php include __DIR__ . '/partials/toast.php'; ?>
</head>
<body>
<h1>Step 3: Get Your File Permissions Ready</h1>
<p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details Accurately</p>

<div class="steps">
    <a class="step"></a>
    <a class="step"></a>
    <a class="step active"></a>
    <a class="step"></a>
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
                href="<?= $allMet ? '?step=environment' : '#' ?>"
                data-all-met="<?= $allMet ? '1' : '0' ?>">
                Next
            </a>
    </div>
</div>
<script src="/install/assets/js/toast.js"></script>
<?php if (isset($_GET['error'])): ?>
    <script>
        const errorParam = new URLSearchParams(window.location.search).get('error');

        let message = 'Something went wrong.';
        switch (errorParam) {
            case 'env':
                message = "Failed to update .env file.";
                break;
            case 'database':
                message = "Database connection failed.";
                break;
            case 'artisan':
                message = "Artisan command failed. Check logs.";
                break;
            case 'requirements':
                message = "Please ensure all the requirements and permission to proceed further!";
                break;
        }
        // Show toast
        showToast(message);

        // Remove the error param from URL after showing toast
        const url = new URL(window.location.href);
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.toString());
    </script>
<?php endif; ?>
</body>
</html>
