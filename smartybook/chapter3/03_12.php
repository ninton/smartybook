<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$siteName = 'Smarty for Designers';
$body = 'コンテンツ本文です。';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('body', $body);
$smarty->display('pages/chapter3/03_12.tpl');
