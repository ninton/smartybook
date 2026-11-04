<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::configure();
$smarty->assign('myDate', time());
$smarty->display('pages/chapter3/03_10.tpl');
