<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$name = 'Smarty';
$description = 'テンプレート・エンジン';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('name', $name);
$smarty->assign('description', $description);
$smarty->display('pages/chapter3/03_02.tpl');
