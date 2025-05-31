<?php

class InstallController
{
    public function welcome()
    {
        include __DIR__ . '/../views/welcome.php';
    }

    public function requirements()
    {
        $requirements = [
            'extensions' => [
                'php' => version_compare(PHP_VERSION, '8.2.0', '>='), // Laravel 11 requires PHP 8.2+
                'openssl' => extension_loaded('openssl'),
                'pdo' => extension_loaded('pdo'),
                'mbstring' => extension_loaded('mbstring'),
                'tokenizer' => extension_loaded('tokenizer'),
                'xml' => extension_loaded('xml'),
                'ctype' => extension_loaded('ctype'),
                'json' => extension_loaded('json'),
                'fileinfo' => extension_loaded('fileinfo'),
                'bcmath' => extension_loaded('bcmath'),
                'curl' => extension_loaded('curl'), // required by Socialite, Pusher, Firebase
                'gd' => extension_loaded('gd') || extension_loaded('imagick'), // required by intervention/image
                'zip' => extension_loaded('zip'), // required by spatie/laravel-backup
                'iconv' => extension_loaded('iconv'), // commonly required by packages like maatwebsite/excel
                'intl' => extension_loaded('intl'), // useful for spatie and other advanced packages
            ],
        ];

        include __DIR__ . '/../views/requirements.php';
    }

    public function permissions()
    {
        $basePath = realpath(__DIR__ . '/../../../'); // Root of Laravel app
        $storagePath = $basePath . '/storage';
        $bootstrapPath = $basePath . '/bootstrap/cache';
        $publicPath = $basePath . '/public';
        $modulesPath = $basePath . '/Modules';

        $folders = [
            'Storage (storage/)' => is_writable($storagePath),
            'Storage Logs (storage/logs)' => is_writable($storagePath . '/logs'),
            'Storage Framework (storage/framework)' => is_writable($storagePath . '/framework'),
            'Storage Framework Cache (storage/framework/cache)' => is_writable($storagePath . '/framework/cache'),
            'Storage Framework Views (storage/framework/views)' => is_writable($storagePath . '/framework/views'),
            'Storage App Public (storage/app/public)' => is_writable($storagePath . '/app/public'),
            'Bootstrap Cache (bootstrap/cache)' => is_writable($bootstrapPath),
            'Modules Directory (Modules/)' => is_dir($modulesPath) && is_writable($modulesPath),
            'Uploads (public/uploads)' => is_dir($publicPath . '/uploads') && is_writable($publicPath . '/uploads'),
        ];

        include __DIR__ . '/../views/permissions.php';
    }


    public function environment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $env = [
                'APP_NAME' => $_POST['app_name'],
                'APP_URL' => $_POST['app_url'],
                'DB_HOST' => $_POST['db_host'],
                'DB_PORT' => $_POST['db_port'],
                'DB_DATABASE' => $_POST['db_database'],
                'DB_USERNAME' => $_POST['db_username'],
                'DB_PASSWORD' => $_POST['db_password'],
            ];

            $envString = '';
            foreach ($env as $key => $value) {
                $envString .= "$key=\"$value\"\n";
            }

            parse_ini_file(__DIR__ . '/../../../.env', $envString);

            header('Location: index.php?step=admin');
            exit;
        }

        include __DIR__ . '/../views/environment.php';
    }

    public function database()
    {
        try {
            $env = parse_ini_file(__DIR__ . '/../../../.env');
            $pdo = new PDO(
                "mysql:host={$env['DB_HOST']};dbname={$env['DB_DATABASE']}",
                $env['DB_USERNAME'],
                $env['DB_PASSWORD']
            );
            if (empty($env['APP_KEY'])) {
                exec('php artisan key:generate --force');
            }
            // Run SQL or artisan migrate
            exec('php ../../../artisan migrate --force');
            exec('php ../../../artisan db:seed --force');

            header('Location: index.php?step=admin');
            exit;
        } catch (Exception $e) {
            echo "DB Error: " . $e->getMessage();
        }
    }

    public function admin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $env = parse_ini_file(__DIR__ . '/../../../.env');
            $pdo = new PDO(
                'mysql:host=' . $env['DB_HOST'] . ';dbname=' . $env['DB_DATABASE'],
                $env['DB_USERNAME'],
                $env['DB_PASSWORD']
            );

            $stmt = $pdo->prepare("INSERT INTO users (first_name,last_name,phone, email, password) VALUES (?,?,?,?,?)");
            $stmt->execute([$first_name, $last_name, $phone, $email, $password]);

            header('Location: index.php?step=complete');
            exit;
        }

        include __DIR__ . '/../views/admin.php';
    }

    public function finish()
    {
        $path = __DIR__ . '/../../../storage';
        $installedFile = $path . '/installed';

        // Create the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Now write the installed file
        file_put_contents($installedFile, date('Y-m-d H:i:s'));

        include __DIR__ . '/../views/finish.php';
    }
}
