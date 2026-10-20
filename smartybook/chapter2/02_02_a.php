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
$count = count($categories);

// 配列データを表示
for ($i = 0; $i < $count; $i++) {
    print '<a href="02_03.php?category=' . $categories[$i] . '">' . $categories[$i] . '</a><br />';
}
?>
</body>
</html>
