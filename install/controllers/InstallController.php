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
            $envUpdates = [
                'APP_NAME' => $_POST['app_name'],
                'DB_HOST' => $_POST['db_host'],
                'DB_PORT' => $_POST['db_port'],
                'DB_DATABASE' => $_POST['db_database'],
                'DB_USERNAME' => $_POST['db_username'],
                'DB_PASSWORD' => $_POST['db_password'],
                'CACHE_STORE' => 'file'
            ];


            $targetPath = realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR . '.env';


            $envContent = file_exists($targetPath) ? file_get_contents($targetPath) : '';

            // Update or insert each key
            foreach ($envUpdates as $key => $value) {
                $pattern = "/^$key=.*$/m";
                $line = $key . '="' . addslashes($value) . '"';

                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $line, $envContent);
                } else {
                    $envContent .= $line . "\n";
                }
            }


            $result = file_put_contents($targetPath, $envContent);

            // Test DB connection first
            try {
                $pdo = new PDO(
                    "mysql:host={$envUpdates['DB_HOST']};dbname={$envUpdates['DB_DATABASE']}",
                    $envUpdates['DB_USERNAME'],
                    $envUpdates['DB_PASSWORD']
                );

            } catch (PDOException $e) {
                // Connection failed
                header('Location: ?step=environment&error=database');
                exit;
            }

            // Change working directory to Laravel root
            $projectRoot = realpath(__DIR__ . '/../../');

            chdir($projectRoot);

//            // Install Composer dependencies
//            exec('composer install --no-interaction --prefer-dist', $composerOutput, $composerStatus);
//
//            // Install NPM dependencies
//            exec('npm install --legacy-peer-deps', $npmOutput, $npmStatus); // safer for older projects

            // Generate key if missing
            $env = $this->parseEnv(); // If you have parseEnv()
            if (empty($env['APP_KEY'])) {
                exec('php artisan key:generate --force');
            }

            // Drop all tables before running migrations
            exec('php artisan db:wipe --force');

            // Create the cache table for database cache
            exec('php artisan cache:table');

            // Run migrations and seeders
            exec('php artisan migrate --force', $outputMigrate, $statusMigrate);
            exec('php artisan module:migrate --all --force', $outputModuleMigrate, $statusModuleMigrate);
//            exec('php artisan db:seed --force', $outputSeed, $statusSeed);
            // 🔍 Return and stop everything else
            echo "<pre>";
            print_r($outputMigrate);
            echo "</pre>";
            return; // 👈 this prevents the rest of the method from running

            // Update the .env key for cache store
            $this->updateEnvKey('CACHE_STORE', 'database');

            // Clear caches
            exec('php artisan config:clear');
            exec('php artisan cache:clear');

            if (
                $result === false ||
                $statusMigrate !== 0 ||
                $statusModuleMigrate !== 0
            ) {
//                // Log everything
//                file_put_contents(__DIR__ . '/../logs/install-error.log', implode("\n", array_merge(
//                    $composerOutput ?? [],
//                    $npmOutput ?? [],
//                    $outputMigrate ?? [],
//                    $outputSeed ?? []
//                )));
                file_put_contents(__DIR__ . '/../logs/install-error.log', implode("\n", array_merge(
                    $outputMigrate ?? [],
                    $outputModuleMigrate ?? [],
                )));
                header('Location: ?step=environment&error=artisan');
            } else {
                header('Location: ?step=admin');
            }

            exit;
        }

        include __DIR__ . '/../views/environment.php';
    }

    public function admin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $slug = $this->username_slug_generator($first_name, $last_name); // Must be defined in included file
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $env = $this->parseEnv();
            $pdo = new PDO(
                'mysql:host=' . $env['DB_HOST'] . ';dbname=' . $env['DB_DATABASE'],
                $env['DB_USERNAME'],
                $env['DB_PASSWORD']
            );

            $stmt = $pdo->prepare("INSERT INTO users (first_name,last_name,slug,phone,email,password,activity_scope) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$first_name, $last_name, $slug, $phone, $email, $password, 'system_level']);

            header('Location: index.php?step=finish');
            exit;
        }

        include __DIR__ . '/../views/admin.php';
    }


    public function finish()
    {
        $path = realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR . '/storage';
        $installedFile = $path . '/installed';

        // Create the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Now write the installed file
        file_put_contents($installedFile, date('Y-m-d H:i:s'));

        include __DIR__ . '/../views/finish.php';
    }

    private function parseEnv()
    {
        $envPath = realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR . '.env';
        if (!file_exists($envPath)) {
            return [];
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $env = [];

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // skip comments
            [$key, $value] = array_pad(explode('=', $line, 2), 2, null);
            if ($value !== null) {
                $env[trim($key)] = trim(trim($value), '"');
            }
        }

        return $env;
    }

    public function updateEnvKey($key, $value)
    {
        $path = realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR . '.env';
        $escapedValue = '"' . addslashes($value) . '"';

        if (file_exists($path)) {
            $envContent = file_get_contents($path);
            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$key}={$escapedValue}", $envContent);
            } else {
                $envContent .= "\n{$key}={$escapedValue}";
            }

            file_put_contents($path, $envContent);
        }
    }

    private function username_slug_generator($first, $last = null)
    {
        $full = trim($first . ' ' . ($last ?? ''));
        $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $full); // Allow uppercase too
        $slug = strtolower($slug); // Then lowercase
        return trim($slug, '-');
    }
}
