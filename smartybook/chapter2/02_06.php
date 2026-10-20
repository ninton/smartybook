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

/**
 * 改行文字,カンマ,クォートを処理する関数
 *
 * @param string $str 入力文字列
 * @return string 処理後の文字列
 */
function convertNl(string $str): string
{
    $str = stripslashes($str);
    $str = str_replace('"', '""', $str);
    return '"' . $str . '"';
}

// ----- ビジネスロジック（CSV保存処理） -----
/**
 * @var string $siteName
 * @var string $adminURL
 */

// POSTデータの取得
$category = $_POST['category'] ?? '';
$rawTitle    = $_POST['title'] ?? '';
$rawContents = $_POST['contents'] ?? '';
$date     = $_POST['date'] ?? '';
$image    = $_POST['image'] ?? '';

// CSVファイルを読み込み、追記両用で開く
$fp = fopen(__DIR__ . '/data.csv', 'a+');
if ($fp === false) {
    die('file_open_error');
}

// CSVファイルをロック
flock($fp, LOCK_EX);

// 最終行のIDをチェック
$lastId = lastIdCheck($fp);

// IDが4桁に満たない番号の場合、0で埋めて4桁表示にする
$id = sprintf('%04d', $lastId + 1);

// 書き込むデータを生成
$title    = convertNl($rawTitle);
$contents = convertNl($rawContents);
$string   = "$id,$category,$title,$contents,$date,$image\n";

// CSVファイルに書き込み
$isSuccess = (fwrite($fp, $string) !== false);

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