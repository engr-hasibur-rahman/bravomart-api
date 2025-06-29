<?php
if (!file_exists(__DIR__ . '/storage/installed')) {
    require __DIR__ . '/install/index.php';
    exit;
}

require __DIR__ . '/public/index.php';