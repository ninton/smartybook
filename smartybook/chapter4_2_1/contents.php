<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/ini.php';
/**
 * ini.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var string[] $categories
 * @var string $csv
 */

// ----- メイン処理・データ操作 -----
// CSVデータを配列に格納
$fp = fopen($csv, 'r');
$data = [];
$i = 0;
while ($array = fgetcsv($fp, 5000, ',', escape: '')) {
    if ($_GET['category'] == $array[1]) {
        $data[$i]['id']       = $array[0];
        $data[$i]['category'] = $array[1];
        $data[$i]['title']    = $array[2];
        $data[$i]['text']     = $array[3];
        $data[$i]['time']     = $array[4];
        $data[$i]['image']    = $array[5];
        $i++;
    }
}
fclose($fp);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
$smarty->assign('data', $data);
$smarty->assign('category', $_GET['category']);
$smarty->display('pages/chapter4_2_1/contents.tpl');
