<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$sites = ['Google', 'MSN', ['Yahoo!', 'Yahoo!Japan']];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('sites', $sites);
$smarty->display('pages/chapter3/03_04.tpl');
