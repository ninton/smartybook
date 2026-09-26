<?php


require_once __DIR__ . '/ini.php';
use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';

/** @var string $siteName */
/** @var string $home */
/** @var string[] $categories */
/** @var string $csv */
/** @var list<array{id: string, category: string, title: string, text: string, time: string, image: string}> $data */

$smarty = new Smarty();

require_once __DIR__ . '/insert.php';
$smarty->registerPlugin('function', 'insert_noticeText2', smarty_insert_noticeText2(...));

$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
//$smarty->assign("notice", $notice);
// CSVデータを配列に格納
$data = [];
$fp = fopen($csv, 'r');
$i = 0;
while ($array = fgetcsv($fp, 5000, ',', escape: '')) {
    if ($array[1] == 'Notice') {
        $notice = $array[3];
        $smarty->assign('notice', $notice);
    }
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
