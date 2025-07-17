<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - License Key Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="/install_local/assets/css/style.css" rel="stylesheet">
    <link href="/install_local/assets/css/toast.css" rel="stylesheet">
    <link href="/install_local/assets/css/loader.css" rel="stylesheet">
    <?php include __DIR__ . '/partials/toast.php'; ?>
</head>

<body>
<h1>Step 1: License Key Verification</h1>
<p class="subtitle">Please provide your valid purchase key to proceed further</p>

<div class="steps">
    <a class="step"></a>
    <a class="step active"></a>
    <a class="step"></a>
    <a class="step"></a>
    <a class="step"></a>
    <a class="step"></a>
    <a class="step"></a>
</div>

<div class="card">
    <h2>Provide your purchase information</h2>
    <form class="form" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" id="username" name="username" placeholder="Enter your Envato username" required>
            </div>
            <div class="form-group">
                <label for="password">Purchase Key</label>
                <div class="input-wrapper">
                    <input type="text" id="purchase_key" name="purchase_key" autocomplete="off"
                           placeholder="Enter your Envato purchase code" required>
                </div>
            </div>
        </div>

        <div class="button-container">
            <p>Please fill up with valid purchase information.</p>
            <button type="submit" class="button">
                Submit
            </button>
        </div>
    </form>
</div>
<div id="loader-overlay" class="hidden">
    <div class="loader"></div>
</div>
<script src="/install_local/assets/js/toast.js"></script>
<?php if (!empty($error)): ?>
    <script>
        const message = <?= json_encode($error) ?>;
        showToast(message);
    </script>
<?php endif; ?>
</body>

</html>