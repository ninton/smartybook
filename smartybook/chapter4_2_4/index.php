<?php


require_once('ini.php');

/**
 * @var string $siteName
 * @var string $home
 * @var array $categories
 * @var string $csv
 */

use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();

// Smarty5 で {insert}タグ廃止予定なので、registerPluginで置き換えました
require_once(__DIR__ . '/insert.php');
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
$smarty->display('index.tpl');
