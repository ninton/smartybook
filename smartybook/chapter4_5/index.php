<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = SmartyFactory::configure();
$smarty->assign('hour', date('G'));
$smarty->display('pages/chapter4_5/index.tpl');
