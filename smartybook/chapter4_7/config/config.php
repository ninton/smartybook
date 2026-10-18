<?php

return [
    // セッションハイジャック対策トークンの塩(しお)
    'token_salt' => $_ENV['TOKEN_SALT'],
    // セッション変数のサイト内の他アプリとの衝突防止
    // $_SESSION[APPID]['form'] = ...; のように使う
    'app_id' => __FILE__,
];
