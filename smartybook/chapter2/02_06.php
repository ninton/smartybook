<?php

// phpcs:disable PSR1.Files.SideEffects

// 設定ファイルの読み込み
require_once('02_01_b.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登録完了 - <?php print $siteName;?></title>
</head>
<body>
<?php
// csvデータの最終行のIDをチェックする関数
function lastIdCheck($file)
{
    while ($arr = fgetcsv($file, 5000, ',')) {
        $lastId = $arr[0];
    }
    if ($lastId == '') {
        $lastId = 0;
    }
    return $lastId;
}
function convertNl($str)
{
    $str = str_replace("\\", "", $str);
    $str = str_replace('"', '""', $str);
    $str = '"' . $str . '"';
    return $str;
}

// CSVファイルを読み込み、追記両用で開く
$fp = fopen('data.csv', 'a+') or die('file_open_error');

// CSVファイルをロック
flock($fp, LOCK_EX);

// 最終行のIDをチェック
$lastId = lastIdCheck($fp);

// IDが4桁に満たない番号の場合、0で埋めて4桁表示にする
$id = sprintf("%04d", $lastId + 1);

// 書き込むデータを生成
$title = convertNl($_POST['title']);
$contents = convertNl($_POST['contents']);
$string = "$id,$_POST[category],$title,$contents,$_POST[date],$_POST[image]\n";
//$string = $id;

// CSVファイルに書き込み
$check = fwrite($fp, $string);

// 書き込みできたかチェック
if ($check == false) {
    print '登録に失敗しました。<br />';
} elseif (is_int($check)) {
    print '正常に登録できました。<br />';
} else {
    print '登録に失敗しました。<br />';
}

// CSVファイルのロックを解除
flock($fp, LOCK_UN);
fclose($fp);
print '<a href="' . $admin . '">登録フォームに戻る</a>';
?>
</body>
</html>
