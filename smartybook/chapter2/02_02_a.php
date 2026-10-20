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
    <title>カテゴリ一覧 - <?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?></title>
</head>
<body>
<h1>カテゴリ一覧</h1>
<?php foreach ($categories as $category): ?>
    <a href="02_03.php?category=<?php echo urlencode($category); ?>"><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></a><br>
<?php endforeach; ?>
</body>
</html>
