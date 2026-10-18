<?php

// セッションハイジャック対策トークンの塩(しお)
const TOKEN_SALT = 'oGU6XrwjQd4NXbpw';
// セッション変数のサイト内の他アプリとの衝突防止
// $_SESSION[APPID]['form'] = ...; のように使う
const APPID = __FILE__;
