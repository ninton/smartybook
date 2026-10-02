<?php

use App\PearStub\PagerStub as Pager;
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter4_6\CMS;
use SmartyBook\chapter4_6\SortNavigator;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

/**
 * @var array{dsn: string, db_user: string, db_password: string, perPage: int, sort: string, order: string} $CONFIG
 */
$CONFIG = require_once __DIR__ . '/config/config.php';

// ----- インラインクラス定義 -----
class PagerDto
{
    public int $ExOffsetFrom;
    public int $ExOffsetTo;
    public string $ExLinks;
    public string $ExFirstPageLink;
    public string $ExLastPageLink;
    public string $ExPreviousPageLink;
    public string $ExNextPageLink;
}

// ----- 入力値受取・前処理 -----
// リクエスト変数を調べて、なければデフォルト値を設定する
//  pageID      ページ番号
//  sort        並び替える項目
//  order       並び替える順序
//  setPerPage  1ページあたりの表示件数
if (empty($_REQUEST['pageID'])) {
    $_REQUEST['pageID'] = 1;
} elseif ((int)$_REQUEST['pageID'] < 1) {
    $_REQUEST['pageID'] = 1;
}

if (empty($_REQUEST['sort'])) {
    $_REQUEST['sort'] = $CONFIG['sort'];
}
if (empty($_REQUEST['order'])) {
    $_REQUEST['order'] = $CONFIG['order'];
}
if (empty($_REQUEST['setPerPage'])) {
    $_REQUEST['setPerPage'] = $CONFIG['perPage'];
}

// ----- メイン処理・データ操作 -----
$cms = new CMS($CONFIG['dsn'], $CONFIG['db_user'], $CONFIG['db_password']);

if ($cms->getCount() < $_REQUEST['pageID']) {
    $_REQUEST['pageID'] = 1;
}

/**
 * @fixme Pagerクラス関連を UIパーツブロックへ移動したい
 * そのために $from と $to を 独自に計算するようにして、Pager クラスに依存しないようにする
 **/
$params = [];
$params['totalItems'] = $cms->getCount();
$params['currentPage'] = (int)$_REQUEST['pageID'];
$pager = Pager::factory($params);

// ページに表示する範囲のデータを読みだす
list($from, $to) = $pager->getOffsetByPageId();
$rcd_arr = [];
if ((0 < $from) && (0 < $to)) {
    $rcd_arr = $cms->getAll($from - 1, $to - $from + 1, $_REQUEST['sort'], $_REQUEST['order']);
}

// ----- UIパーツ -----
/**
 * PagerExクラスにプロパティを追加する
 * @fixme chapter5_3/lib/pager_ex.php の pager_ex 関数を参考にして関数などにしたい
 */
$pagerDto = new PagerDto();
$pagerDto->ExOffsetFrom   = $from;
$pagerDto->ExOffsetTo     = $to;
$links = $pager->getLinks();
$pagerDto->ExLinks = $links['pages'];
$pagerDto->ExFirstPageLink    = '';
$pagerDto->ExLastPageLink     = '';
$pagerDto->ExPreviousPageLink = '';
$pagerDto->ExNextPageLink     = '';

if (preg_match('/href="(.*?)"/', $links['first'], $matches)) {
    $pagerDto->ExFirstPageLink    = $matches[1];
}
if (preg_match('/href="(.*?)"/', $links['last'], $matches)) {
    $pagerDto->ExLastPageLink    = $matches[1];
}
if (preg_match('/href="(.*?)"/', $links['back'], $matches)) {
    $pagerDto->ExPreviousPageLink    = $matches[1];
}
if (preg_match('/href="(.*?)"/', $links['next'], $matches)) {
    $pagerDto->ExNextPageLink    = $matches[1];
}

// 並替えの△▽を表示するクラス
$sortnavi = new SortNavigator($_REQUEST['sort'], $_REQUEST['order']);
$perpage_params = [
    'optionText' => '%d件/ページ',
    'attributes' => "onchange='document.forms[\"perPage\"].submit()'",
];

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('SortNavi', $sortnavi);
$smarty->assign('Pager', $pager);
$smarty->assign('PagerDto', $pagerDto);
$smarty->assign('popup_params', ['autoSubmit' => true]);
$smarty->assign('perpage_params', $perpage_params);
$smarty->assign('rcd_arr', $rcd_arr);
$smarty->display('pages/chapter4_6/index.tpl');
