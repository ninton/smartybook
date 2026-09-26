<?php

/**
 * 【歴史的経緯・リファクタリングに関する注記】
 * このファイルは出版当時の実装（Smartyテンプレートを用いてXMLを出力する構成）を
 * そのまま保持し、PHP 8.x + Smarty 5 環境での Golden Master テスト対象としています。
 *
 * 現代の PHP 開発における定石：
 * - XML を出力する場合：Smarty テンプレートではなく DOMDocument や SimpleXMLElement を使用する
 * - JSON を出力する場合：Smarty テンプレートではなく json_encode() を使用する
 */

header('Content-Type: application/xml; charset=UTF-8');
require_once('ini.php');
use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
/** @var string $siteName */
/** @var string $home */
/** @var string[] $categories */
/** @var string $csv */
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
//$smarty->assign("notice", $notice);
// CSVデータを配列に格納
$fp = fopen($csv, 'r');
$i = 0;
/** @var array<int, array<string, mixed>> $data */
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
$smarty->display('xml.tpl');

/**
 * @return string
 */
function insert_noticeText(): string
{
    $noticeText = '<img src="./images/banner.gif" />';
    return $noticeText;
}

/**
 * @param array<string, mixed> $siteName
 * @return string
 */
function smarty_insert_noticeText2(array $siteName): string
{
    return '<img src="./images/banner.gif" /><br />' . $siteName['siteName'];
}
