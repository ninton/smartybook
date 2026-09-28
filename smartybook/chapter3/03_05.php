<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
// 連想配列
$sites = ['name' => 'Google', 'url' => 'http://www.google.com/'];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('sites', $sites);
$smarty->display('pages/chapter3/03_05.tpl');
