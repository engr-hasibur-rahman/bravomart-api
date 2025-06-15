<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Database Setup</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .form-group {
            position: relative;
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
    <h1>Step 4: Enter Admin Information</h1>
    <p class="subtitle">Follow The Step-By-Step Instructions And Input The Required Details For Database Accurately</p>

    <div class="steps">
        <a class="step" href="?step=welcome"></a>
        <a class="step" href="?step=requirements"></a>
        <a class="step" href="?step=permissions"></a>
        <a class="step" href="?step=environment"></a>
        <a class="step active" href="?step=admin"></a>
        <a class="step" href="?step=finish"></a>
    </div>

    <div class="card">
        <h2>Provide your admin information</h2>
        <form class="form" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter Your First Name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter Your Last Name">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter Your Phone Number">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter Your Email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="toggle-password-icon" onclick="togglePassword(this)">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirm_password" placeholder="Confirm Password">
                        <span class="toggle-password-icon" onclick="togglePassword(this)">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" class="submit-btn">
                    Create Admin
                </button>
            </div>
        </form>
    </div>
    <script>
        function togglePassword(icon) {
            const input = icon.previousElementSibling;
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');

            const iconElement = icon.querySelector('i');
            iconElement.classList.toggle('fa-eye');
            iconElement.classList.toggle('fa-eye-slash');
        }
    </script>
</body>

</html>