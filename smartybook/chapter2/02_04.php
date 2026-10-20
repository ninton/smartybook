<?php
// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

/**
 * @var string $siteName
 * @var list<string> $categories
 */

$now = time();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>登録フォーム - <?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?></title>
</head>
<body>
<form method="post" action="02_05.php" enctype="multipart/form-data">
<table>
<tr>
    <td><label for="category">カテゴリ</label></td>
    <td>
        <select name="category" id="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
        </select>
    </td>
</tr>
<tr>
    <td><label for="title">タイトル</label></td>
    <td><input type="text" name="title" id="title" required maxlength="100"></td>
</tr>
<tr>
    <td><label for="contents">本文</label></td>
    <td><textarea name="contents" id="contents" cols="50" rows="3" required maxlength="1000"></textarea></td>
</tr>
<tr>
    <td>日時</td>
    <td>
        <?php echo date('Y-m-d H:i:s', $now); ?>
        <input type="hidden" name="date" value="<?php echo htmlspecialchars((string)$now, ENT_QUOTES, 'UTF-8'); ?>">
    </td>
</tr>
<tr>
    <td><label for="image">画像</label></td>
    <td><input type="file" name="image" id="image"></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="登録確認"></td>
</tr>
</table>
</form>
</body>
</html>
