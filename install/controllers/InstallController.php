<?php

class InstallController
{
    public function welcome()
    {
        include __DIR__ . '/../views/welcome.php';
    }

    public function requirements()
    {
        // PHP version and extensions
        $requirements = [
            'php' => version_compare(PHP_VERSION, '8.1.0', '>='),
            'extensions' => [
                'openssl' => extension_loaded('openssl'),
                'pdo' => extension_loaded('pdo'),
                'mbstring' => extension_loaded('mbstring'),
                'tokenizer' => extension_loaded('tokenizer'),
                'xml' => extension_loaded('xml'),
                'ctype' => extension_loaded('ctype'),
                'json' => extension_loaded('json'),
                'fileinfo' => extension_loaded('fileinfo'),
                'bcmath' => extension_loaded('bcmath'),
            ]
        ];
//        // This makes $requirements available in the view
//        extract(['requirements' => $requirements]);
        include __DIR__ . '/../views/requirements.php';
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

            file_put_contents(__DIR__ . '/../../../.env', $envString);

            header('Location: index.php?step=admin');
            exit;
        }

        include __DIR__ . '/../views/environment.php';
    }

    public function permissions()
    {
        $folders = [
            'storage/' => is_writable(__DIR__ . '/../../../storage'),
            'bootstrap/cache/' => is_writable(__DIR__ . '/../../../bootstrap/cache'),
        ];
        include __DIR__ . '/../views/permissions.php';
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
            // Run SQL or artisan migrate
            exec('php ../../../artisan migrate --force');
            exec('php ../../../artisan db:seed --force');

            header('Location: ?step=admin');
            exit;
        } catch (Exception $e) {
            echo "DB Error: " . $e->getMessage();
        }
    }
    public function admin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $pdo = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $password]);

            header('Location: index.php?step=complete');
            exit;
        }

        include __DIR__ . '/../views/admin.php';
    }
    public function finish()
    {
        file_put_contents(__DIR__ . '/../../../storage/installed', date('Y-m-d H:i:s'));
        echo "Installation complete. <a href='/admin/login'>Go to Admin Panel</a>";
    }
}
