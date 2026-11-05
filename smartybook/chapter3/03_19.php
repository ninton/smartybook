<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
$person = [
    ['name' => '国枝', 'height' => '156cm'],
    ['name' => '大沢', 'height' => '165cm'],
    ['name' => '加藤', 'height' => '167cm'],
];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('person', $person);
$smarty->display('pages/chapter3/03_19.tpl');
