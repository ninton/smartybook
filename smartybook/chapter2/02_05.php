<?php

declare(strict_types=1);

// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

/**
 * @var string $siteName
 * @var string $imageDir
 * @var list<string> $categories
 */

// ----- データ準備 & バリデーション (400 Bad Request) -----
$category = $_POST['category'] ?? '';
if (!is_string($_POST['title'] ?? '') || !is_string($_POST['contents'] ?? '')) {
    http_response_code(400);
    echo 'タイトルと本文は文字列で入力してください。';
    exit;
}
$title    = trim($_POST['title'] ?? '');
// 改行コードを \n (LF) に統一してから trim
$rawContents = $_POST['contents'] ?? '';
$contents    = trim(str_replace("\r\n", "\n", $rawContents));

// 1. カテゴリの存在チェック
if (!in_array($category, $categories, true)) {
    http_response_code(400);
    echo '不正なカテゴリが選択されました。';
    exit;
}

// 2. 必須入力チェック（タイトル・本文）
if ($title === '' || $contents === '') {
    http_response_code(400);
    echo 'タイトルと本文は必須項目です。';
    exit;
}

// 3. 文字数制限チェック（タイトル: 100文字、本文: 1000文字）
if (mb_strlen($title, 'UTF-8') > 100) {
    http_response_code(400);
    echo 'タイトルは100文字以内で入力してください。';
    exit;
}

if (mb_strlen($contents, 'UTF-8') > 1000) {
    http_response_code(400);
    echo '本文は1000文字以内で入力してください。';
    exit;
}

// 保存先ディレクトリの存在確認（存在しない場合は環境・設定エラーとして終了）
if (!is_dir($imageDir)) {
    http_response_code(500);
    echo '画像保存ディレクトリが存在しません。環境設定を確認してください。';
    exit;
}

// 画像ファイルのアップロード処理
$imageFile = '';
if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // 拡張子の取得（小文字化）
    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    // 一意なファイル名の生成（例: 20261020_65f1a2b3c4d5.jpg）
    $fileName = date('Ymd_') . bin2hex(random_bytes(8)) . ($extension !== '' ? '.' . $extension : '');

    $targetPath = $imageDir . '/' . $fileName;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $imageFile = $targetPath;
    }
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
<input type="hidden" name="image" value="<?php echo htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8'); ?>">
</form>
</body>
</html>
