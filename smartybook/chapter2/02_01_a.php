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

// カテゴリ一覧
$categoryList[0] = 'Study';
$categoryList[1] = 'Eating';
$categoryList[2] = 'Work';

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
echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') . '<br>';
echo $revision . '<br>';
echo htmlspecialchars($csvFilePath, ENT_QUOTES, 'UTF-8') . '<br>';
echo htmlspecialchars($imageDir, ENT_QUOTES, 'UTF-8') . '<br>';
echo htmlspecialchars($homeURL, ENT_QUOTES, 'UTF-8') . '<br>';
echo htmlspecialchars($adminURL, ENT_QUOTES, 'UTF-8') . '<br>';
echo htmlspecialchars($categoryList[0], ENT_QUOTES, 'UTF-8') . '<br>';
echo htmlspecialchars($categoryList[1], ENT_QUOTES, 'UTF-8') . '<br>';
echo htmlspecialchars($categoryList[2], ENT_QUOTES, 'UTF-8') . '<br>';
?>
</body>
</html>
