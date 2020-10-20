<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
$category[0] = 'Study';
$category[1] = 'Eating';
$category[2] = 'Work';

echo $siteName.'<br />';
echo $revision.'<br />';
echo $csv.'<br />';
echo $imageDir.'<br />';
echo $home.'<br />';
echo $admin.'<br />';
echo $category[0].'<br />';
echo $category[1].'<br />';
echo $category[2].'<br />';
?>
</body>
</html>
