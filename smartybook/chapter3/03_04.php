<?php

use App\Smarty\SmartyFactory;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

// データ準備
// 不均一な配列は現代のPHPで推奨されないので、
// 行ごとの構造（列数）を揃えた均一な2次元配列として定義しました
$siteNameList = [
    ['Google', 'Google Japan'],
    ['MSN', 'MSN Japan'],
    ['Yahoo!', 'Yahoo!Japan'],
];

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = SmartyFactory::create();
$smarty->assign('siteNameList', $siteNameList);
$smarty->display('pages/chapter3/03_04.tpl');
