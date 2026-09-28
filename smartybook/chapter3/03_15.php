<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

// データ準備
$name = ['八代', '国枝', '大石'];
$height = ['167', '156', '182', '200'];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('name', $name);
$smarty->assign('height', $height);
$smarty->display('pages/chapter3/03_15.tpl');
