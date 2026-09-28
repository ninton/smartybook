<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$result = mt_rand(1, 3);

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('result', $result);
$smarty->display('pages/chapter3/03_14.tpl');
