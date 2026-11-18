<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
// 1つのサイトに関する情報（名前とURL）をキー付き配列（連想配列）として定義
$siteInfo = [
    'name' => 'Google',
    'url' => 'https://www.google.com/',
];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('siteInfo', $siteInfo);
$smarty->display('pages/chapter3/03_05.tpl');
