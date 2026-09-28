<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$person = [
    ['name' => '国枝', 'height' => '156'],
    ['name' => '大沢', 'height' => '165'],
    ['name' => '加藤', 'height' => '167'],
];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('person', $person);
$smarty->display('pages/chapter3/03_17.tpl');
