<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>文字や数字を表示</title>
</head>
<body>
<?php
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

// カテゴリ一覧
$categories[0] = 'Study';
$categories[1] = 'Eating';
$categories[2] = 'Work';

echo $siteName . '<br />';
echo $revision . '<br />';
echo $csv . '<br />';
echo $imageDir . '<br />';
echo $home . '<br />';
echo $admin . '<br />';
echo $categories[0] . '<br />';
echo $categories[1] . '<br />';
echo $categories[2] . '<br />';
?>
</body>
</html>
