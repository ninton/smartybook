<?php

require_once('Pager.php');
require_once('../smarty/libs/Smarty.class.php');
require_once('./CMS.class.php');
require_once('./SortNavigator.class.php');
require_once('./config.php');

$smarty   = new Smarty();
$smarty->config_load("index.conf");

// リクエスト変数を調べて、なければデフォルト値を設定する
//  pageID      ページ番号
//  sort        並び替える項目
//  order       並び替える順序
//  setPerPage  1ページあたりの表示件数
if (empty($_REQUEST['pageID'])) {
    $_REQUEST['pageID'] = 1;
}
if (empty($_REQUEST['sort'])) {
    $_REQUEST['sort'] = $smarty->get_config_vars('sort');
}
if (empty($_REQUEST['order'])) {
    $_REQUEST['order'] = $smarty->get_config_vars('order');
}
if (empty($_REQUEST['setPerPage'])) {
    $_REQUEST['setPerPage'] = $smarty->get_config_vars('perPage');
}

// 全件数を調べて、Pagerを初期化する
$cms = new CMS($CONFIG['dsn'], $CONFIG['db_user']);

$params = array();
$params['totalItems'] = $cms->getCount();
$pager = Pager::factory($params);

// ページ番号の調整
if ((int)$_REQUEST['pageID'] < 1) {
    $_REQUEST['pageID'] = 1;
}
if ($pager->numPages() < $_REQUEST['pageID']) {
    $_REQUEST['pageID'] = 1;
}
// ページに表示する範囲のデータを読みだす
list($from, $to) = $pager->getOffsetByPageId($_REQUEST['pageID']);
$rcd_arr = array();
if ((0 < $from) && (0 < $to)) {
    $rcd_arr = $cms->getAll($from - 1, $to - $from + 1, $_REQUEST['sort'], $_REQUEST['order']);
}

// Pagerクラスにプロパティを追加する
$pager->ExOffsetFrom   = $from;
$pager->ExOffsetTo     = $to;
$links = $pager->getLinks();
$pager->ExLinks = $links['pages'];
$pager->ExFirstPageLink    = '';
$pager->ExLastPageLink     = '';
$pager->ExPreviousPageLink = '';
$pager->ExNextPageLink     = '';

if (preg_match('/href="(.*?)"/', $links['first'], $matches)) {
    $pager->ExFirstPageLink    = $matches[1];
}
if (preg_match('/href="(.*?)"/', $links['last'], $matches)) {
    $pager->ExLastPageLink    = $matches[1];
}
if (preg_match('/href="(.*?)"/', $links['back'], $matches)) {
    $pager->ExPreviousPageLink    = $matches[1];
}
if (preg_match('/href="(.*?)"/', $links['next'], $matches)) {
    $pager->ExNextPageLink    = $matches[1];
}

// 並替えの△▽を表示するクラス
$sortnavi = new SortNavigator($_REQUEST['sort'], $_REQUEST['order']);

$smarty->assign("SortNavi", $sortnavi);
$smarty->assign("Pager", $pager);
$smarty->assign('popup_params', array('autoSubmit' => true));
$smarty->assign('perpage_params', array('optionText' => '%d件/ページ', 'attributes' => "onchange='document.forms[\"perPage\"].submit()'"));
$smarty->assign("rcd_arr", $rcd_arr);
$smarty->display("index.tpl");
