<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';
/**
 * 【歴史的経緯・リファクタリングに関する注記】
 * このファイルは出版当時の実装（Smartyテンプレートを用いてXMLを出力する構成）を
 * そのまま保持し、PHP 8.x + Smarty 5 環境での Golden Master テスト対象としています。
 *
 * 現代の PHP 開発における定石：
 * - XML を出力する場合：Smarty テンプレートではなく DOMDocument や SimpleXMLElement を使用する
 * - JSON を出力する場合：Smarty テンプレートではなく json_encode() を使用する
 *
 * config/config.phpで定義されている変数
 * @var string $siteName
 * @var string $homeURL
 * @var list<string> $categories
 * @var string $csvFilePath
 */

header('Content-Type: application/xml; charset=UTF-8');
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('homeURL', $homeURL);
$smarty->assign('categories', $categories);
//$smarty->assign("notice", $notice);
// CSVデータを配列に格納
$fp = fopen($csvFilePath, 'r');
$i = 0;
/** @var array<int, array<string, mixed>> $data */
while ($array = fgetcsv($fp, 5000, escape: '')) {
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
$smarty->display('pages/chapter5_1/xml.tpl');
