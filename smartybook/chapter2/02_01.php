<?php

// ----- データ準備 -----
// ウェブサイト名
$siteName = 'Smarty for Designers';

// バージョン番号
$revision = 1;

// CSVファイル名
$csv = 'data.csv';

// 画像ディレクトリ
$imageDir = './images/';

//トップページ
$home = '02_02.php';

//管理ページ
$admin = '02_04.php';

// ----- HTML表示 -----
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>文字や数字を表示</title>
</head>
<body>
<?php
echo $siteName;
echo $revision;
echo $csv;
echo $imageDir;
echo $home;
echo $admin;
?>
</body>
</html>
