<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$group = [
    ['森永', '国枝'],
    ['水村', '渋谷', '原田'],
    ['北野', '村井'],
];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('group', $group);
$smarty->display('pages/chapter3/03_16.tpl');
