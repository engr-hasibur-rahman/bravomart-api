<?php
session_start();
$step = $_GET['step'] ?? 'welcome';
require_once __DIR__ . '/controllers/InstallController.php';
$controller = new InstallController();

switch ($step) {
    case 'requirements':
        $controller->requirements();
        break;
    case 'permissions':
        $controller->permissions();
        break;
    case 'environment':
        $controller->environment();
        break;
    case 'admin':
        $controller->admin();
        break;
    case 'finish':
        $controller->finish();
        break;
    default:
        $controller->welcome();
        break;
}