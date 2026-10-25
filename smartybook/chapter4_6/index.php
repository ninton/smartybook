<?php

use App\Database\EntryQueryService;
use App\PearStub\PagerStub as Pager;
use App\PearStub\PearPagerMapper;
use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

/**
 * @var array{dsn: string, db_user: string, db_password: string, perPage: int, sort_key: string, sort_direction: string} $config
 */
$config = require_once __DIR__ . '/config/config.php';

// ----- インラインクラス定義 -----

// ----- 入力値受取・前処理 -----
// リクエスト変数を調べて、なければデフォルト値を設定する
//  pageID      ページ番号
//  sort        並び替える項目
//  order       並び替える順序
//  setPerPage  1ページあたりの表示件数
if (empty($_GET['pageID'])) {
    $pageID = 1;
} elseif ((int)$_GET['pageID'] < 1) {
    $pageID = 1;
} else {
    $pageID = (int)$_GET['pageID'];
}

$sortKey = empty($_GET['sort_key']) ? $config['sort_key'] : $_GET['sort_key'];
$sortDirection = empty($_GET['sort_direction']) ? $config['sort_direction'] : $_GET['sort_direction'];
$perPage = empty($_GET['setPerPage']) ? $config['perPage'] : $_GET['setPerPage'];

// ----- メイン処理・データ操作 -----
$pdo = new PDO($config['dsn'], $config['db_user'], $config['db_password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$entryQueryService = new EntryQueryService($pdo);

if ($entryQueryService->count() < $pageID) {
    $pageID = 1;
}

/**
 * @fixme Pagerクラス関連を UIパーツブロックへ移動したい
 * そのために $from と $to を 独自に計算するようにして、Pager クラスに依存しないようにする
 **/
$params = [
    'totalItems' => $entryQueryService->count(),
    'currentPage' => $pageID,
    'perPage' => $perPage,
];
$pager = Pager::factory($params);

$pagerDto = PearPagerMapper::toDto($pager);

// ページに表示する範囲のデータを読みだす
$entryArr = [];
if ((0 < $pagerDto->offsetFrom) && (0 < $pagerDto->offsetTo)) {
    $entryArr = $entryQueryService->findList($pagerDto->offsetFrom - 1, $pagerDto->offsetTo - $pagerDto->offsetFrom + 1, $sortKey, $sortDirection);
}

// ----- UIパーツ -----
// 表示件数の選択肢（例: 1〜20件、ステップ1、あるいは任意の配列）
$perPageOptions = [];
for ($i = 1; $i <= 20; $i += 1) {
    $perPageOptions[$i] = "{$i}件/ページ";
}

// 表示ページ番号の選択肢を作成
$pageOptions = [];
for ($i = 1; $i <= $pagerDto->numPages; $i += 1) {
    $pageOptions[$i] = "{$i}";
}

// JS用キャッシュバスター
$jsPath = __DIR__ . '/js/index.js';
// ファイルが存在すればSHA-1ハッシュを取得（短く最初の8文字に削る）
$jsVersion = file_exists($jsPath) ? substr(sha1_file($jsPath), 0, 8) : '1.0.0';

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('sortKey', $sortKey);
$smarty->assign('sortDirection', $sortDirection);
$smarty->assign('pagerDto', $pagerDto);
$smarty->assign('perPageOptions', $perPageOptions);
$smarty->assign('currentPerPage', $perPage);
$smarty->assign('pageOptions', $pageOptions);
$smarty->assign('entryArr', $entryArr);
$smarty->assign('jsVersion', $jsVersion);
$smarty->display('pages/chapter4_6/index.tpl');
