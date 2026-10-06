<?php

/**
 * @note 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * スタブに置き換えています
 */

use App\Smarty\AppSmarty;
use SmartyBook\chapter5_6\src\AppAmazon;
use SmartyBook\chapter5_6\src\MyListRepository;
use SmartyBook\chapter5_6\src\SmartyPlugin\MbTruncateModifier;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
$config = require_once __DIR__ . '/config/config.php';

// ----- メイン処理・データ操作 -----
$myListRepository = new MyListRepository($config['max_items'], $config['my_list_dir']);
$myList = $myListRepository->read();
if ($myList === null) {
    die('read error');
}

$appAmazon = new AppAmazon($config['access_key_id'], $config['secret_access_key'], $config['associate_tag']);

$options['ResponseGroup'] = 'Medium';
$itemArr = [];
$message = $appAmazon->ItemLookup($myList->getASINs(), $options, $itemArr);

$myList->setItems($itemArr);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new AppSmarty();
$smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
$smarty->assign('CFG', $config);
$smarty->assign('message', $message);
$smarty->assign('myList', $myList);
$smarty->display('pages/chapter5_6/view.tpl');
