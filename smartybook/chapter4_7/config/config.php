<?php

// セッションハイジャック対策トークンの塩(しお)
define('TOKEN_SALT', $_ENV['TOKEN_SALT']);
// セッション変数のサイト内の他アプリとの衝突防止
// $_SESSION[APPID]['form'] = ...; のように使う
define('APPID', __FILE__);
