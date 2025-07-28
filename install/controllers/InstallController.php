<?php
// Laravel Boot
require_once realpath(__DIR__ . '/../../vendor/autoload.php');
$app = require_once realpath(__DIR__ . '/../../bootstrap/app.php');
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
                'php' => version_compare(PHP_VERSION, '8.2.0', '>='),
                'openssl' => extension_loaded('openssl'),
                'pdo' => extension_loaded('pdo'),
                'mbstring' => extension_loaded('mbstring'),
                'tokenizer' => extension_loaded('tokenizer'),
                'xml' => extension_loaded('xml'),
                'ctype' => extension_loaded('ctype'),
                'json' => extension_loaded('json'),
                'fileinfo' => extension_loaded('fileinfo'),
                'bcmath' => extension_loaded('bcmath'),
                'curl' => extension_loaded('curl'),
                'gd' => extension_loaded('gd') || extension_loaded('imagick'),
                'zip' => extension_loaded('zip'),
                'iconv' => extension_loaded('iconv'),
                'intl' => extension_loaded('intl'),
            ],
        ];

        include __DIR__ . '/../views/requirements.php';

    }

    public function permissions()
    {
        if (!$this->isAllRequirementsOk()) {
            header('Location: ?step=requirements');
        }

        $basePath = realpath(__DIR__ . '/../../'); // Root of Laravel app
        $storagePath = $basePath . '/storage';
        $bootstrapPath = $basePath . '/bootstrap/cache';
        $publicPath = $basePath . '/public';
        $modulesPath = $basePath . '/Modules';

        $folders = [
            'Storage (storage/)' => is_writable($storagePath),
            'Storage App Public (storage/app/public)' => is_writable($storagePath . '/app/public'),
            'Bootstrap Cache (bootstrap/cache)' => is_writable($bootstrapPath),
            'Modules Directory (Modules/)' => is_dir($modulesPath) && is_writable($modulesPath),
            'App (storage/app)' => is_writable($storagePath . '/app'),
            'Logs (storage/logs)' => is_writable($storagePath . '/logs'),
            'Framework (storage/framework)' => is_writable($storagePath . '/framework'),
        ];

        if (!$this->isAllPermissionOk()) {
            header('Location: ?step=permissions&error=requirements');
        }

        include __DIR__ . '/../views/permissions.php';

    }

    public function environment()
    {
        if (!$this->isAllPermissionOk()) {
            header('Location: ?step=permissions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $envUpdates = [
                'APP_NAME' => $_POST['app_name'] ?? '',
                'DB_HOST' => $_POST['db_host'] ?? '',
                'DB_PORT' => $_POST['db_port'] ?? '3306',
                'DB_DATABASE' => $_POST['db_database'] ?? '',
                'ADMIN_URL' => $_POST['admin_url'] ?? '',
                'FRONTEND_URL' => $_POST['frontend_url'] ?? '',
                'DB_USERNAME' => $_POST['db_username'] ?? '',
                'DB_PASSWORD' => $_POST['db_password'] ?? '',
                'CACHE_STORE' => 'file',
            ];
            $installation_mode = $_POST['install_mode'];

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

            if ($result === false) {
                $this->logError('Failed to write .env file.');
                header('Location: ?step=environment&error=envwrite');
                exit;
            }

            // Test DB connection first
            try {
                $pdo = new PDO(
                    "mysql:host={$envUpdates['DB_HOST']};dbname={$envUpdates['DB_DATABASE']}",
                    $envUpdates['DB_USERNAME'],
                    $envUpdates['DB_PASSWORD']
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $this->logError("DB Connection failed: " . $e->getMessage());
                header('Location: ?step=environment&error=database');
                exit;
            }

            // Change working directory to Laravel root
            $projectRoot = realpath(__DIR__ . '/../../');
            chdir($projectRoot);

            // Generate key if missing
            $env = $this->parseEnv(); // Assuming parseEnv() returns array of env vars
            if (empty($env['APP_KEY'])) {
                exec('php artisan key:generate --force 2>&1', $outputKeyGen, $codeKeyGen);
                if ($codeKeyGen !== 0) {
                    $this->logError("Key generation failed:\n" . implode("\n", $outputKeyGen));
                }
            }

            // Clear config before wiping
            exec('php artisan config:clear 2>&1');

            // Wipe database
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

            $pdo->exec("SET foreign_key_checks = 0;");
            foreach ($tables as $table) {
                $pdo->exec("DROP TABLE IF EXISTS `$table`");
            }

            $pdo->exec("SET foreign_key_checks = 1;");

            // Create the cache table for database cache
            exec('php artisan cache:table 2>&1', $outputCacheTable, $codeCacheTable);

            // Update the .env key for cache store
            $this->updateEnvKey('CACHE_STORE', 'database');
            exec('php artisan migrate --force 2>&1', $outputMigrate, $codeMigrate);

            // Clear caches
            exec('php artisan config:clear 2>&1');
            exec('php artisan cache:clear 2>&1');

            $requirements = $this->isAllRequirementsOk();
            $permissions = $this->isAllPermissionOk();

            // Import SQL
            $sqlFile = realpath(__DIR__ . '/../database/bravo_fresh.sql');

            if ($installation_mode === 'demo') {
                if (file_exists($sqlFile)) {
                    $sql = file_get_contents($sqlFile);
                    if ($sql !== false) {
                        try {
                            $pdo->exec($sql);
                        } catch (PDOException $e) {
                            $this->logError("SQL import failed: " . $e->getMessage());
                            die('SQL import failed. Check logs.');
                        }
                    } else {
                        die('Could not read SQL file.');
                    }
                } else {
                    die('SQL file not found.');
                }
            } else {
                if ($sqlFile === false) {
                    http_response_code(500);
                    echo "<pre>File not found at expected path.</pre>";
                    echo "<pre>Checked path: " . __DIR__ . '/../database/bravo_fresh.sql' . "</pre>";
                    exit;
                }
                if (file_exists($sqlFile)) {
                    $sql = file_get_contents($sqlFile);
                    if ($sql !== false) {
                        try {
                            $pdo->exec($sql);
                        } catch (PDOException $e) {
                            $this->logError("SQL import failed: " . $e->getMessage());
                            die('SQL import failed. Check logs.');
                        }
                    } else {
                        die('Could not read SQL file.');
                    }
                } else {
                    die('SQL file not found.');
                }
            }

            if ($result === false) {
                file_put_contents(__DIR__ . '/../logs/install-error.log', implode("\n", array_merge(
                    $outputMigrate ?? [],
                    $outputModuleMigrate ?? []
                )));
                header('Location: ?step=environment&error=artisan');
                exit;
            } elseif (!$requirements || !$permissions) {
                header('Location: ?step=environment&error=requirements');
                exit;
            } else {
                header('Location: ?step=admin');
                exit;
            }
        }

        include __DIR__ . '/../views/environment.php';
    }

    private function logError(string $message): void
    {
        $logFile = __DIR__ . '/../install-error.log';
        $formattedMessage = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;
        file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    }

    public function admin()
    {

        if (!$this->isAllRequirementsOk()) {
            header('Location: ?step=requirements');
        }
        if (!$this->isAllPermissionOk()) {
            header('Location: ?step=permissions');
        }
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

            $stmt = $pdo->prepare("INSERT INTO users (id, first_name, last_name, slug, phone, email, password, activity_scope,email_verified,status)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?)");
            $stmt->execute([8, $first_name, $last_name, $slug, $phone, $email, $password, 'system_level', 1, 1]);

            header('Location: index.php?step=finish');
            exit;
        }

        include __DIR__ . '/../views/admin.php';


    }


    public function finish()
    {

        // If requirements and permissions are missing
        if (!$this->isAllRequirementsOk()) {
            header('Location: ?step=requirements');
        }
        if (!$this->isAllPermissionOk()) {
            header('Location: ?step=permissions');
        }

        $path = realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR . '/storage';
        $installedFile = $path . '/installed';

        // Create the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Now write the installed file
        file_put_contents($installedFile, date('Y-m-d H:i:s'));

        // Disable demo mode automatically in .env and set INSTALLED=true
        $envPath = realpath(__DIR__ . '/../..') . '/.env';

        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);

            // Disable DEMO_MODE
            if (preg_match('/^DEMO_MODE=.*$/m', $envContent)) {
                $envContent = preg_replace('/^DEMO_MODE=.*$/m', 'DEMO_MODE=false', $envContent);
            } else {
                $envContent .= "\nDEMO_MODE=false";
            }

            // Add or update INSTALLED=true
            if (preg_match('/^INSTALLED=.*$/m', $envContent)) {
                $envContent = preg_replace('/^INSTALLED=.*$/m', 'INSTALLED=true', $envContent);
            } else {
                $envContent .= "\nINSTALLED=true";
            }

            file_put_contents($envPath, $envContent);
        }

        $env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

        $adminUrl = isset($env['ADMIN_URL']) ? trim($env['ADMIN_URL'], '"') : '#';
        $frontendUrl = isset($env['FRONTEND_URL']) ? trim($env['FRONTEND_URL'], '"') : '#';

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

    private function isAllRequirementsOk()
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

        if (in_array(false, $requirements['extensions'], true)) {
            return false;
        }

        return $requirements;
    }

    private function isAllPermissionOk()
    {
        $basePath = realpath(__DIR__ . '/../../'); // Root of Laravel app (/../../ for live)
        $storagePath = $basePath . '/storage';
        $bootstrapPath = $basePath . '/bootstrap/cache';
        $publicPath = $basePath . '/public';
        $modulesPath = $basePath . '/Modules';

        $folders = [
            'Storage (storage/)' => is_writable($storagePath),
            'Storage App Public (storage/app/public)' => is_writable($storagePath . '/app/public'),
            'Bootstrap Cache (bootstrap/cache)' => is_writable($bootstrapPath),
            'Modules Directory (Modules/)' => is_dir($modulesPath) && is_writable($modulesPath),
            'App (storage/app)' => is_writable($storagePath . '/app'),
            'Logs (storage/logs)' => is_writable($storagePath . '/logs'),
            'Framework (storage/framework)' => is_writable($storagePath . '/framework'),
        ];
        if (in_array(false, $folders, true)) {
            return false;
        }
        return $folders;
    }

    private function username_slug_generator($first, $last = null)
    {
        $full = trim($first . ' ' . ($last ?? ''));
        $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $full); // Allow uppercase too
        $slug = strtolower($slug); // Then lowercase
        return trim($slug, '-');
    }
}
