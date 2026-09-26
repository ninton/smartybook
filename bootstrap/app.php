<?php

declare(strict_types=1);

use Dotenv\Dotenv;

if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

// Composer オートロードの読み込み
require_once PROJECT_ROOT . '/vendor/autoload.php';

// .env 読み込み
if (file_exists(PROJECT_ROOT . '/.env')) {
    $dotenv = Dotenv::createImmutable(PROJECT_ROOT);
    $dotenv->load();
}
