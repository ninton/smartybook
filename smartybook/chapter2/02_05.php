<?php
// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

/**
 * @var string $siteName
 * @var string $imageDir
 */

// ----- データ準備・ファイル処理 -----
$category = $_POST['category'] ?? '';
$title    = $_POST['title'] ?? '';
$contents = $_POST['contents'] ?? '';
$date     = (int)($_POST['date'] ?? 0);

// 画像ディレクトリの存在確認・作成
if (!is_dir($imageDir)) {
    mkdir($imageDir);
}

// 画像ファイルのアップロード処理
$imageFile = '';
if (isset($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    $imageFile = $imageDir . $_FILES['image']['name'];
    copy($_FILES['image']['tmp_name'], $imageFile);
}

// ----- HTML表示 -----
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>登録確認 - <?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?></title>
</head>
<body>
<form method="post" action="02_06.php">
<table>
<tr>
    <td>カテゴリ</td>
    <td><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></td>
</tr>
<tr>
    <td>タイトル</td>
    <td><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></td>
</tr>
<tr>
    <td>本文</td>
    <td><?php echo nl2br(htmlspecialchars($contents, ENT_QUOTES, 'UTF-8'), false); ?></td>
</tr>
<tr>
    <td>日時</td>
    <td><?php echo date('Y-m-d H:i:s', $date); ?></td>
</tr>
<tr>
    <td>画像</td>
    <td>
        <?php if ($imageFile !== ''): ?>
            <img src="<?php echo htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8'); ?>" alt="">
        <?php else: ?>
            ファイルは指定されていません。
        <?php endif; ?>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="登録"> <input type="button" value="戻る" onClick="history.back()"></td>
</tr>
</table>

<input type="hidden" name="category" value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="title" value="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="contents" value="<?php echo htmlspecialchars($contents, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="date" value="<?php echo htmlspecialchars((string)$date, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="image" value="<?php echo htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8'); ?>">
</form>
</body>
</html>
