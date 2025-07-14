<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Installer redirection logic (no redirect, just include)
if (!file_exists(__DIR__ . '/../storage/installed')) {
    require __DIR__ . '/../install_local/index.php';
    exit;
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());