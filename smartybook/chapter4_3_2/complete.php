<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';

// ----- インライン関数定義 -----
/**
 * 最新記事ID（CSVファイルの最終行のID）を取得する関数
 * @param resource $file CSVファイルのファイルポインタ
 * @return int 最新記事ID
 */
function lastIdCheck($file): int
{
    while ($arr = fgetcsv($file, 5000, ',', escape: '')) {
        $lastId = (int)$arr[0];
    }
    return $lastId ?? 0;
}

/**
 * 改行文字,カンマ,クォートを処理する関数
 * @param string $str 入力文字列
 * @return string 処理後の文字列
 */
function convertNl(string $str): string
{
    $str = stripslashes($str);
    $str = str_replace('"', '""', $str);
    $str = '"' . $str . '"';
    return $str;
}

/**
 * config/config.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var string $admin
 */

// ----- 入力値受取・前処理 -----
// 本文の改行文字,カンマ,ダブルクォートの処理
$title = convertNl($_POST['title']);
$contents = convertNl($_POST['contents']);

// ----- メイン処理・データ操作 -----
// 記事の書き込み
$fp = fopen(__DIR__ . '/data.csv', 'a+') or die('file_open_error');
flock($fp, LOCK_EX);

$lastId = lastIdCheck($fp);
$id = sprintf('%04d', $lastId + 1);

$string = $id . ','
        . $_POST['category'] . ','
        . $title . ','
        . $contents . ','
        . $_POST['date'] . ','
        . $_POST['image'] . "\n";

$check = fwrite($fp, $string);
flock($fp, LOCK_UN);
fclose($fp);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
$smarty->assign('flag', $check !== false);
$smarty->display('pages/chapter4_3_2/complete.tpl');
