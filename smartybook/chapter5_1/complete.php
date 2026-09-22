<?php


require_once('ini.php');
use Smarty\Smarty;

require_once('../../vendor/autoload.php');
$smarty = new Smarty();
/** @var string $siteName */
/** @var string $home */
/** @var string $admin */
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);

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

// 改行文字,カンマ,クォートを処理する関数
function convertNl($str)
{
    $str = stripslashes($str);
    $str = str_replace('"', '""', $str);
    $str = '"' . $str . '"';
    return $str;
}
// 記事の書き込み
$fp = fopen('data.csv', 'a+') or die('file_open_error');
flock($fp, LOCK_EX);
$lastId = lastIdCheck($fp);
$id = sprintf('%04d', $lastId + 1);
// 本文の改行文字,カンマ,ダブルクォートの処理
$title = convertNl($_POST['title']);
$contents = convertNl($_POST['contents']);

$string = $id . ','
    . $_POST['category'] . ','
    . $title . ','
    . $contents . ','
    . $_POST['date'] . ','
    . $_POST['image'] . "\n";

$check = fwrite($fp, $string);
if ($check === false) {
    $smarty->assign('flag', 'FALSE');
} else {
    $smarty->assign('flag', 'TRUE');
}
flock($fp, LOCK_UN);
fclose($fp);
//出力
$smarty->display('complete.tpl');
