<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
// 連想配列
$sites = ['name' => 'Google', 'url' => 'https://www.google.com/'];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::configure();
$smarty->assign('sites', $sites);
$smarty->display('pages/chapter3/03_05.tpl');
