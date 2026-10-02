<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';

/**
 * config/config.phpで定義されている変数
 * @var string $siteName
 * @var string $siteDescription
 * @var string $home
 * @var list<string> $categories
 * @var string $csv
 */

// ----- 前処理（初期化・共通変数準備） -----
// キャッシュ判定に Smartyオブジェクトが必要なので、描画セクションではなく、前処理でSmartyオブジェクトを生成します
$smarty = new Smarty();
$smarty->caching = \Smarty\Smarty::CACHING_LIFETIME_CURRENT;
// PHPやテンプレートを変更したら 60秒経過してからリロードしてください
$smarty->cache_lifetime = 60;

// ----- メイン処理・データ操作 -----
// キャッシュが無効・または存在しない場合のみ、重い処理（ファイル読み込み・データ整形）を実行
$template = 'pages/chapter5_4/index.tpl';

if (!$smarty->isCached($template)) {
    $picture = [];
    $data = [];
    $notice  = '';

    // CSVデータを配列に格納
    $fp = fopen($csv, 'r');
    $i = 0;
    $p = 0;

    while ($array = fgetcsv($fp, 5000, ',', escape: '')) {
        if ($array[1] == 'Picture') {
            $picture[$p]['id']       = $array[0];
            $picture[$p]['category'] = $array[1];
            $picture[$p]['title']    = $array[2];
            $picture[$p]['text']     = $array[3];
            $picture[$p]['time']     = $array[4];
            $picture[$p]['image']    = $array[5];
            $p++;
        } elseif ($array[1] == 'Notice') {
            $notice = $array[3];
        } else {
            $data[$i]['id']       = $array[0];
            $data[$i]['category'] = $array[1];
            $data[$i]['title']    = $array[2];
            $data[$i]['text']     = $array[3];
            $data[$i]['time']     = $array[4];
            $data[$i]['image']    = $array[5];
            $i++;
        }
    }
    fclose($fp);

    /**
     * @note Twitter API はサービス停止しました。代わりにダミーデータJSONを読み込みます
     *
     * 執筆当時のキャッシュ利用の意図
     * API レスポンスに時間がかかることがある。
     * 頻繁にレスポンス内容が変わらないだろう。
     * キャッシュを利用しようという意図でした。
     */
    $twitterUrl =  __DIR__ . '/kara_d.json';
    $jTwitter = file_get_contents($twitterUrl);
    $aTwitter = json_decode($jTwitter);

    // ----- テンプレートエンジンへの変数アサイン -----
    $smarty->assign('data', $data);
    $smarty->assign('picture', $picture);
    $smarty->assign('notice', $notice);
    $smarty->assign('aTwitter', $aTwitter);
    $smarty->assign('siteName', $siteName);
    $smarty->assign('siteDescription', $siteDescription);
    $smarty->assign('home', $home);
    $smarty->assign('categories', $categories);
}

// ----- テンプレートエンジン描画 -----
$smarty->display($template);
