<?php
// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

/**
 * @var string $siteName
 * @var list<string> $categoryList
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
<a href="02_03.php?category=<?php echo urlencode($categoryList[0]); ?>"><?php echo htmlspecialchars($categoryList[0], ENT_QUOTES, 'UTF-8'); ?></a><br>
<a href="02_03.php?category=<?php echo urlencode($categoryList[1]); ?>"><?php echo htmlspecialchars($categoryList[1], ENT_QUOTES, 'UTF-8'); ?></a><br>
<a href="02_03.php?category=<?php echo urlencode($categoryList[2]); ?>"><?php echo htmlspecialchars($categoryList[2], ENT_QUOTES, 'UTF-8'); ?></a><br>
</body>
</html>
