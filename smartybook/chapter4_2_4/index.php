<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
require_once __DIR__ . '/ini.php';
/**
 * ini.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var list<string> $categories
 * @var string $csv
 */
$smarty = new Smarty();

// Smarty5 で {insert}タグ廃止予定なので、registerPluginで置き換えました
require_once __DIR__ . '/insert.php';
$smarty->registerPlugin('function', 'insert_noticeText2', smarty_insert_noticeText2(...));

$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
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
//データをsmartyの変数として格納
$smarty->assign('data', $data);
//出力
$smarty->display('pages/chapter4_2_4/index.tpl');
