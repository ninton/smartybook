<?php

declare(strict_types=1);

// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

// ----- インライン関数定義 -----
/**
 * 次の発行対象となるID（最終行のID + 1）を取得する
 *
 * @param resource $fileHandle CSVファイルのファイルポインタ（末尾まで読み進められます）
 * @return int 次のID
 */
function getNextId($fileHandle): int
{
    $lastId = null;

    while ($row = fgetcsv($fileHandle, 5000, escape: '')) {
        if (isset($row[0]) && is_numeric($row[0])) {
            $lastId = (int)$row[0];
        }
    }

    // データが存在しなければ 1、存在すれば 最終ID + 1
    if ($lastId === null) {
        return 1;
    }

    return $lastId + 1;
}

// ----- データ準備 & バリデーション (400 Bad Request) -----
/**
 * @var string $siteName
 * @var string $adminURL
 * @var list<string> $categories
 * @var string $csvFilePath
 */

$category = $_POST['category'] ?? '';
if (!is_string($_POST['title'] ?? '') || !is_string($_POST['contents'] ?? '')) {
    http_response_code(400);
    echo 'タイトルと本文は文字列で入力してください。';
    exit;
}

// 改行コードを \n (LF) に統一してから trim
$rawContents = $_POST['contents'] ?? '';
$title       = trim($_POST['title'] ?? '');
$contents    = trim(str_replace("\r\n", "\n", $rawContents));
$image       = $_POST['image'] ?? '';

// 1. カテゴリの存在チェック
if (!in_array($category, $categories, true)) {
    http_response_code(400);
    echo '不正なカテゴリが選択されました。';
    exit;
}

// 2. 必須入力チェック
if ($title === '' || $contents === '') {
    http_response_code(400);
    echo 'タイトルと本文は必須項目です。';
    exit;
}

// 3. 文字数制限チェック
if (mb_strlen($title, 'UTF-8') > 100 || mb_strlen($contents, 'UTF-8') > 1000) {
    http_response_code(400);
    echo '入力文字数の制限を超えています。';
    exit;
}

// ----- ビジネスロジック（CSV保存処理） -----
// CSVファイルを読み込み、追記両用で開く
$fileHandle = fopen($csvFilePath, 'a+');
if ($fileHandle === false) {
    http_response_code(500);
    echo 'データファイルのオープンに失敗しました。';
    exit;
}

// CSVファイルをロック
flock($fileHandle, LOCK_EX);

// 新規IDを取得（内部でポインタが末尾に移動するため、そのまま追記可能）
$nextId = getNextId($fileHandle);

// 保存実行時の現在日時（UNIXタイムスタンプ）をサーバー側で自動取得
$nowTimestamp = (new DateTimeImmutable())->getTimestamp();

// 書き込む配列データを準備（fputcsv が適切にエスケープとクォートを処理）
$row = [$nextId, $category, $title, $contents, (string)$nowTimestamp, $image];

// CSVファイルに書き込み (PHP 8.4+ escape: '' 明示)
$isSuccess = (fputcsv($fileHandle, $row, escape: '') !== false);

// CSVファイルのロックを解除・クローズ
flock($fileHandle, LOCK_UN);
fclose($fileHandle);

// ----- HTML表示部 -----
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>登録完了 - <?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?></title>
</head>
<body>

<?php if ($isSuccess): ?>
    <p>正常に登録できました。</p>
<?php else: ?>
    <p>登録に失敗しました。</p>
<?php endif; ?>

<p><a href="<?php echo htmlspecialchars($adminURL, ENT_QUOTES, 'UTF-8'); ?>">登録フォームに戻る</a></p>

</body>
</html>
