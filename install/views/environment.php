<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Database Setup</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/toast.css" rel="stylesheet">
    <link href="assets/css/loader.css" rel="stylesheet">
    <?php include 'views/partials/toast.php'; ?>
    <style>
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .form-group {
            position: relative;
            /* Needed for absolute icon positioning */
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
    <p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details Accurately</p>

    <div class="steps">
        <a class="step" href="?step=welcome"></a>
        <a class="step" href="?step=requirements"></a>
        <a class="step" href="?step=permissions"></a>
        <a class="step active" href="?step=environment"></a>
        <a class="step" href="?step=admin"></a>
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

            <div class="button-container">
                <button type="submit" class="submit-btn">Next</button>
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
        document.querySelector('.form').addEventListener('submit', function() {
            document.getElementById('loader-overlay').classList.remove('hidden');
        });
    </script>
    <script src="assets/js/toast.js"></script>
    <?php if (isset($_GET['error'])): ?>
        <script>
            showToast("Failed to update .env file.");
            // Remove ?error=1 from the URL after toast is shown
            const url = new URL(window.location.href);
            url.searchParams.delete('error');
            window.history.replaceState({}, document.title, url.toString());
        </script>
    <?php endif; ?>
</body>

</html>