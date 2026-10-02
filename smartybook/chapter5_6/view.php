<?php

/**
 * @note 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * スタブに置き換えています
 */
use SmartyBook\chapter5_6\_read\classes\AppAmazon;
use SmartyBook\chapter5_6\_read\classes\AppSmarty;
use SmartyBook\chapter5_6\_read\classes\MyListManager;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/_read/inc.php';

/**
 * @var array<string, mixed> $CFG
 */

// ----- 入力値受取・前処理 -----
if (empty($_REQUEST['ListId'])) {
    $_REQUEST['ListId'] = 1;
}

// ----- メイン処理・データ操作 -----
$mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
$mylist = $mylistmgr->read($_REQUEST['ListId']);
if ($mylist === null) {
    die('read error');
}

$appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['secret_access_key'], $CFG['associate_tag']);

$options['ResponseGroup'] = 'Medium';
$Item_arr = [];
$message = $appAmazon->ItemLookup($mylist->getASINs(), $options, $Item_arr);

$mylist->setItems($Item_arr);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new AppSmarty();
$smarty->assign('CFG', $CFG);
$smarty->assign('message', $message);
$smarty->assign('mylist', $mylist);
$smarty->display('pages/chapter5_6/view.tpl');
