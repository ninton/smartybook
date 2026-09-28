<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$name = 'Smartyさん';
$type = 'テンプレート・エンジン';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('name', $name);
$smarty->assign('type', $type);
$smarty->display('pages/chapter3/03_02.tpl');
