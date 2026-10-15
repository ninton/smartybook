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
return [
    'dsn'         => sprintf('mysql:dbname=%s;host=%s;charset=utf8mb4', envString('DB_DATABASE'), envString('DB_HOST')),
    'db_user'     => envString('DB_USER'),
    'db_password' => envString('DB_PASSWORD'),
    'perPage'     => 5,
    'sort'        => 'id',
    'order'       => 'asc',
];
