<?php


require_once('ini.php');

/**
 * @var string $siteName
 * @var string $home
 * @var string[] $categories
 * @var string $csv
 * @var list<array<string, string|int>> $data
 */

use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
// Smarty 5 から insertタグは廃止されました。代わりに registerPlugin を使って関数プラグインを登録します。
$smarty->registerPlugin('function', 'insert_noticeText', 'insert_noticeText');
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
// CSVデータを配列に格納
$fp = fopen($csv, 'r');
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
//データをsmartyの変数として格納
$smarty->assign('data', $data);
$smarty->assign('category', $_GET['category']);
//出力
$smarty->display('contents.tpl');
/**
 * @return string
 */
function insert_noticeText(): string
{
    $noticeText = '<img src="./images/banner.gif" />';
    return $noticeText;
}
