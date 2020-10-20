<?php
// セッションハイジャック対策トークンの塩(しお)
define( 'TOKEN_SALT', 'oGU6XrwjQd4NXbpw' );

// セッション変数のサイト内の他アプリとの衝突防止
// $_SESSION[APPID]['form'] = ...; のように使う
define( 'APPID', __FILE__ );
?>