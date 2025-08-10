<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Database Setup</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="/install/assets/css/style.css" rel="stylesheet">
    <link href="/install/assets/css/toast.css" rel="stylesheet">
    <link href="/install/assets/css/loader.css" rel="stylesheet">
    <?php include __DIR__ . '/partials/toast.php'; ?>
</head>

<body>
<h1>Step 4: Enter Database Information</h1>
<p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details Accurately</p>

<div class="steps">
    <a class="step"></a>
    <a class="step"></a>
    <a class="step"></a>
    <a class="step active"></a>
    <a class="step"></a>
    <a class="step"></a>
</div>

<div class="card">
    <h2>Provide your database information</h2>
    <form class="form" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="app_name">Site Name</label>
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
                <label for="admin_url">Admin Panel Url</label>
                <input type="text" id="admin_url" name="admin_url" placeholder="https://admin.bravomart.app/" required>
            </div>

            <div class="form-group">
                <label for="frontend_url">Frontend Url</label>
                <input type="text" id="frontend_url" name="frontend_url" placeholder="https://public.bravomart.app/"
                       required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="db_username">Database Username</label>
                <input type="text" id="db_username" name="db_username" placeholder="root" required>
            </div>

            <div class="form-group">
                <label for="db_password">Database Password</label>
                <div class="input-wrapper">
                    <input type="password" name="db_password" id="db_password" class="toggle-password-input">
                    <span class="toggle-password-icon" onclick="togglePassword(this)">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Install Mode</label>
                <div class="toggle-group" id="installModeToggle">
                    <label class="toggle-option" id="optionDemo">
                        <input type="radio" name="install_mode" value="demo" required>
                        Start with Demo Data
                    </label>
                    <label class="toggle-option" id="optionFresh">
                        <input type="radio" name="install_mode" value="fresh">
                        Start with Empty Database
                    </label>
                </div>
            </div>
        </div>

        <div class="button-container">
            <p>Please fill up the correct environment details.</p>
            <button type="submit" class="button">Next</button>
        </div>
    </form>
</div>
<div id="loader-overlay" class="hidden">
    <div class="loader"></div>
</div>
<script>
    // Reset loader if shown
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('loader-overlay').classList.add('hidden');
    });

    function togglePassword(icon) {
        const input = icon.previousElementSibling;
        const isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');

        const iconElement = icon.querySelector('i');
        iconElement.classList.toggle('fa-eye');
        iconElement.classList.toggle('fa-eye-slash');
    }

    // Show loader on form submit
    document.querySelector('.form').addEventListener('submit', function () {
        document.getElementById('loader-overlay').classList.remove('hidden');
    });
</script>
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
<script>
    const toggleOptions = document.querySelectorAll('.toggle-option');

    toggleOptions.forEach(option => {
        option.addEventListener('click', () => {
            toggleOptions.forEach(o => o.classList.remove('active'));
            option.classList.add('active');
            option.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>
</body>

</html>