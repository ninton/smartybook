<?php

use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter4_2_4\src\SmartyPlugin\NoticeTextFunction;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';

/**
 * config/config.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var list<string> $categories
 * @var string $csv
 */

// ----- メイン処理・データ操作 -----
// CSVデータを配列に格納
$data = [];
$fp = fopen($csv, 'r');
$i = 0;
while ($array = fgetcsv($fp, 5000, ',', escape: '')) {
    $data[$i]['id']       = $array[0];
    $data[$i]['category'] = $array[1];
    $data[$i]['title']    = $array[2];
    $data[$i]['text']     = $array[3];
    $data[$i]['time']     = $array[4];
    $data[$i]['image']    = $array[5];
    $i++;
}
fclose($fp);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
// Smarty5 で {insert}タグ廃止予定なので、registerPluginで置き換えました
$smarty->registerPlugin('function', 'insert_noticeText2', NoticeTextFunction::render(...));
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
$smarty->assign('data', $data);
$smarty->display('pages/chapter4_2_4/index.tpl');
