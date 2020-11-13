<?php
// 設定ファイルの読み込み
require_once('02_01_b.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>詳細表示 - <?php print $siteName;?></title>
</head>
<body>
<?php
// ファイルを読み込み専用で開く
$fp = fopen($csv, 'r');
print '<h1>カテゴリ：' . $_GET['category'] . '</h1>';
print '<hr />';

// CSVデータの詳細を表示
while ($arr = fgetcsv($fp, 5000, ',')) {
    if ($_GET['category'] == $arr[1]) {
        print '記事ID：' . $arr[0] . '<br />';
        print '<h2>' . $arr[2] . '</h2>';
        print $arr[3] . '<br />';
        print date("Y-m-d H:i:s", $arr[4]) . '<br />';
        print '<img src="' . $arr[5] . '" />';
        print '<hr />';
    }
}
// CSVファイルを閉じる
fclose($fp);
print '<a href="' . $home . '">カテゴリ一覧に戻る</a>';
?>
</body>
</html>
