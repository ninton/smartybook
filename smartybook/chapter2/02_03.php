<?php
// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

/**
 * @var string $siteName
 * @var string $csvFilePath
 * @var string $homeURL
 * @var list<string> $categories
 */

// ----- データ準備 & バリデーション -----
$selectedCategory = $_GET['category'] ?? '';

// $categories に含まれていない場合は 404 レスポンスを返して終了
if (!in_array($selectedCategory, $categories, true)) {
    http_response_code(404);
    echo '指定されたカテゴリは見つかりませんでした。';
    exit;
}

// タイムゾーンの明示設定
$timezone = new DateTimeZone('Asia/Tokyo');

// 対象カテゴリの記事データを抽出
$items = [];
if (($fileHandle = fopen($csvFilePath, 'r')) !== false) {
    while (($row = fgetcsv($fileHandle, 5000, escape: '')) !== false) {
        // UNIXタイムスタンプから DateTimeImmutable を生成し、JSTで整形
        $createdAt = (new DateTimeImmutable())
            ->setTimezone($timezone)
            ->setTimestamp((int)$row[4]);

        if ($selectedCategory === $row[1]) {
            $items[] = [
                'id'        => $row[0],
                'title'     => $row[2],
                'body'      => $row[3],
                'createdAtFormatted' => $createdAt->format('Y-m-d H:i:s'),
                'imagePath' => $row[5],
            ];
        }
    }
    fclose($fileHandle);
}

// ----- HTML表示 -----
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>詳細表示 - <?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?></title>
</head>
<body>
<h1>カテゴリ：<?php echo htmlspecialchars($selectedCategory, ENT_QUOTES, 'UTF-8'); ?></h1>
<hr>

<?php foreach ($items as $item): ?>
    記事ID：<?php echo htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8'); ?><br>
    <h2><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
    <?php echo htmlspecialchars($item['body'], ENT_QUOTES, 'UTF-8'); ?><br>
    <?php echo htmlspecialchars($item['createdAtFormatted'], ENT_QUOTES, 'UTF-8'); ?><br>
    <img src="<?php echo htmlspecialchars($item['imagePath'], ENT_QUOTES, 'UTF-8'); ?>" alt=""><br>
    <hr>
<?php endforeach; ?>

<a href="<?php echo htmlspecialchars($homeURL, ENT_QUOTES, 'UTF-8'); ?>">カテゴリ一覧に戻る</a>
</body>
</html>
