<?php
// 設定ファイルの読み込み
require_once __DIR__ . '/02_01_b.php';

// ----- インライン関数定義 -----
/**
 * 最新記事ID（CSVファイルの最終行のID）を取得する関数
 *
 * @param resource $file CSVファイルのファイルポインタ
 * @return int 最新記事ID
 */
function lastIdCheck($file): int
{
    $lastId = 0;
    while ($arr = fgetcsv($file, 5000, escape: '')) {
        if (isset($arr[0])) {
            $lastId = (int)$arr[0];
        }
    }
    return $lastId;
}

// ----- データ準備 & バリデーション (400 Bad Request) -----
/**
 * @var string $siteName
 * @var string $adminURL
 * @var list<string> $categories
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
$date        = (int)($_POST['date'] ?? 0);
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

// 4. 日時データの正当性チェック
if (!is_string($_POST['date'] ?? null) || filter_var($_POST['date'], FILTER_VALIDATE_INT) === false || $date <= 0) {
    http_response_code(400);
    echo '不正な日時データです。';
    exit;
}

// ----- ビジネスロジック（CSV保存処理） -----
// CSVファイルを読み込み、追記両用で開く
$fp = fopen(__DIR__ . '/data.csv', 'a+');
if ($fp === false) {
    http_response_code(500);
    echo 'データファイルのオープンに失敗しました。';
    exit;
}

// CSVファイルをロック
flock($fp, LOCK_EX);

// 最終行のIDをチェック
$lastId = lastIdCheck($fp);

// IDが4桁に満たない番号の場合、0で埋めて4桁表示にする
$id = sprintf('%04d', $lastId + 1);

// 書き込む配列データを準備（fputcsv が適切にエスケープとクォートを処理）
$row = [$id, $category, $title, $contents, (string)$date, $image];

// CSVファイルに書き込み (PHP 8.4+ escape: '' 明示)
$isSuccess = (fputcsv($fp, $row, escape: '') !== false);

// CSVファイルのロックを解除・クローズ
flock($fp, LOCK_UN);
fclose($fp);

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
