<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
require_once __DIR__ . '/ini.php';
/**
 * ini.phpで定義されている変数
 * @var string $siteName
 * @var string $csv
 * @var string $imageDir
 * @var string $home
 * @var string $admin
 * @var list<string> $categories
 * @var list<array{id: string, category: string, title: string, text: string, time: string, image: string}> $data
 */
$smarty = new Smarty();

$smarty->registerPlugin('function', 'insert_noticeText2', insert_noticeText2(...));

$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
// CSVデータを配列に格納
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

/**
 * @param array{siteName: string} $siteName
 * @return string
 */
function insert_noticeText2(array $siteName): string
{
    return '<img src="./images/banner.gif" /><br />' . $siteName['siteName'];
}
