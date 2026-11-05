<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$siteName = 'Smarty for Designers';
$body = 'コンテンツ本文です。';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('siteName', $siteName);
$smarty->assign('body', $body);
$smarty->display('pages/chapter3/03_12.tpl');
