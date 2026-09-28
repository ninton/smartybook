<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

//CSVファイルパス
$csv = __DIR__ . '/data.csv';

$smarty = new Smarty();
// CSVデータを配列に格納
/** @var array<int, array<string, string>> $data */
$data = [];
$fp = fopen($csv, 'r');
$i = 0;
while ($array = fgetcsv($fp, 5000, ',', escape: '')) {
    $data[$i]['id']       = $array[0];
    $data[$i]['category'] = $array[1];
    $data[$i]['title']    = $array[2];
    $data[$i]['time']     = $array[3];
    $data[$i]['author']   = $array[4];
    $i++;
}
fclose($fp);
$smarty->assign('data', $data);
$smarty->display('pages/chapter4_4/index.tpl');
