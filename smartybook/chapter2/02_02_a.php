<?php
// 設定ファイルの読み込み
require_once('02_01_b.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>カテゴリ一覧 - <?php print $siteName;?></title>
</head>
<body>
<h1>カテゴリ一覧</h1>
<?php
$count = count($categories);

// 配列データを表示
for ($i = 0; $i < $count; $i++) {
    print '<a href="02_03.php?category=' . $categories[$i] . '">' . $categories[$i] . '</a><br />';
}
?>
</body>
</html>
