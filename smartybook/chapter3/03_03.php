<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$sites = ['Google', 'MSN', 'Yahoo!'];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('sites', $sites);
$smarty->display('pages/chapter3/03_03.tpl');
