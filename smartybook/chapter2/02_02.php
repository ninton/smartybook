<?php
// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

/**
 * @var string $siteName
 * @var list<string> $categories
 */
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>カテゴリ一覧 - <?php print $siteName;?></title>
</head>
<body>
<h1>カテゴリ一覧</h1>
<?php
// 配列データを表示
print '<a href="02_03.php?category=' . $categories[0] . '">' . $categories[0] . '</a><br />';
print '<a href="02_03.php?category=' . $categories[1] . '">' . $categories[1] . '</a><br />';
print '<a href="02_03.php?category=' . $categories[2] . '">' . $categories[2] . '</a><br />';
?>
</body>
</html>
