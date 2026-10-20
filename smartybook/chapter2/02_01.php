<?php

// ----- データ準備 -----
// ウェブサイト名
$siteName = 'Smarty for Designers';

// バージョン番号
$revision = 1;

// CSVファイル名
$csvFilePath = 'data.csv';

// 画像ディレクトリ
$imageDir = './images/';

// トップページ
$homeURL = '02_02.php';

// 管理ページ
$adminURL = '02_04.php';

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
echo $csvFilePath;
echo $imageDir;
echo $homeURL;
echo $adminURL;
?>
</body>
</html>
