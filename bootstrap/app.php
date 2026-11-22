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

define('SMARTY_CACHE_DIR', PROJECT_ROOT . '/cache');
define('SMARTY_COMPILE_DIR', PROJECT_ROOT . '/templates_c');
define('SMARTY_TEMPLATE_DIR', PROJECT_ROOT . '/templates');

/*
 * テンプレート側の表示設定（.conf）は .tpl と同列に配置します（PHPからは参照しない前提）。
 * 例:
 * - templates/pages/chapter3/03_07.tpl
 * - templates/pages/chapter3/03_07.conf
 */
define('SMARTY_CONFIG_DIR', SMARTY_TEMPLATE_DIR);
