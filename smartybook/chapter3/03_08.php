<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('name1', 'Smartyさん');
$smarty->assign('name2', '');
$smarty->display('pages/chapter3/03_08.tpl');
