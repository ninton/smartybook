<?php

use App\PearStub\PagerStub as Pager;
use App\PearStub\PearPagerMapper;
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter4_6\src\CMS;
use SmartyBook\chapter4_6\src\SortNavigator;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

/**
 * @var array{dsn: string, db_user: string, db_password: string, perPage: int, sort: string, order: string} $config
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

$sort = empty($_GET['sort']) ? $config['sort'] : $_GET['sort'];
$order = empty($_GET['order']) ? $config['order'] : $_GET['order'];
$perPage = empty($_GET['setPerPage']) ? $config['perPage'] : $_GET['setPerPage'];

// ----- メイン処理・データ操作 -----
$pdo = new PDO($config['dsn'], $config['db_user'], $config['db_password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$cms = new CMS($pdo);

if ($cms->getCount() < $pageID) {
    $pageID = 1;
}

/**
 * @fixme Pagerクラス関連を UIパーツブロックへ移動したい
 * そのために $from と $to を 独自に計算するようにして、Pager クラスに依存しないようにする
 **/
$params = [
    'totalItems' => $cms->getCount(),
    'currentPage' => $pageID,
    'perPage' => $perPage,
];
$pager = Pager::factory($params);

$pagerDto = PearPagerMapper::toDto($pager);

// ページに表示する範囲のデータを読みだす
$entryArr = [];
if ((0 < $pagerDto->offsetFrom) && (0 < $pagerDto->offsetTo)) {
    $entryArr = $cms->findList($pagerDto->offsetFrom - 1, $pagerDto->offsetTo - $pagerDto->offsetFrom + 1, $sort, $order);
}

// ----- UIパーツ -----

// 並替えの△▽を表示するクラス
$sortNavigator = new SortNavigator($sort, $order);

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

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('sort', $sort);
$smarty->assign('order', $order);
$smarty->assign('sortNavigator', $sortNavigator);
$smarty->assign('pagerDto', $pagerDto);
$smarty->assign('perPageOptions', $perPageOptions);
$smarty->assign('currentPerPage', $perPage);
$smarty->assign('pageOptions', $pageOptions);
$smarty->assign('entryArr', $entryArr);
$smarty->display('pages/chapter4_6/index.tpl');
