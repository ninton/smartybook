<?php

declare(strict_types=1);

/**
 * 環境変数を文字列として安全に取得する
 */
function envString(string $key, string $defaultValue = ''): string
{
    $val = $_ENV[$key] ?? getenv($key);
    if (is_string($val) && $val !== '') {
        return $val;
    }
    return $defaultValue;
}

// $_ENV または getenv から安全に取得（型を string に確定させる）
$dbHost     = envString('DB_HOST');
$dbDatabase = envString('DB_DATABASE');
$dbUser     = envString('DB_USER');
$dbPassword = envString('DB_PASSWORD');

// PDO設定
$CONFIG['dsn'] = sprintf('mysql:dbname=%s;host=%s', $dbDatabase, $dbHost);
$CONFIG['db_user'] = $dbUser;
$CONFIG['db_password'] = $dbPassword;
