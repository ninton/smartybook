<?php

use App\PearStub\PagerStub as Pager;
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter4_6\src\CMS;
use SmartyBook\chapter4_6\src\PearPagerMapper;
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
$cms = new CMS($config['dsn'], $config['db_user'], $config['db_password']);

if ($cms->getCount() < $pageID) {
    $pageID = 1;
}

/**
 * @fixme Pagerクラス関連を UIパーツブロックへ移動したい
 * そのために $from と $to を 独自に計算するようにして、Pager クラスに依存しないようにする
 **/
$params = [];
$params['totalItems'] = $cms->getCount();
$params['currentPage'] = $pageID;
$params['perPage'] = $perPage;
$pager = Pager::factory($params);

// ページに表示する範囲のデータを読みだす
list($from, $to) = $pager->getOffsetByPageId();
$rcd_arr = [];
if ((0 < $from) && (0 < $to)) {
    $rcd_arr = $cms->getAll($from - 1, $to - $from + 1, $sort, $order);
}

// ----- UIパーツ -----
$pagerDto = PearPagerMapper::toDto($pager, $from, $to);

// 並替えの△▽を表示するクラス
$sortnavi = new SortNavigator($sort, $order);
$perpage_params = [
    'optionText' => '%d件/ページ',
    'attributes' => "onchange='document.forms[\"perPage\"].submit()'",
];

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('sort', $sort);
$smarty->assign('order', $order);
$smarty->assign('SortNavi', $sortnavi);
$smarty->assign('Pager', $pager);
$smarty->assign('PagerDto', $pagerDto);
$smarty->assign('popup_params', ['autoSubmit' => true]);
$smarty->assign('perpage_params', $perpage_params);
$smarty->assign('rcd_arr', $rcd_arr);
$smarty->display('pages/chapter4_6/index.tpl');
