<?php

require_once('./_read/inc.php');

use SmartyBook\chapter5_6\_read\classes\AppAmazon;
use SmartyBook\chapter5_6\_read\classes\AppSmarty;
use SmartyBook\chapter5_6\_read\classes\MyListManager;

if (empty($_REQUEST['ListId'])) {
    $_REQUEST['ListId'] = 1;
}
$mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
$mylist = $mylistmgr->read($_REQUEST['ListId']);
if ($mylist === null) {
    die('read error');
}
$appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['associate_id'], $CFG['aws_cache_dir']);
$options['ResponseGroup'] = 'Medium';
$message = $appAmazon->ItemLookup($mylist->getASINs(), $options, $Item_arr);
$mylist->setItems($Item_arr);
$smarty = new AppSmarty();
$smarty->assign("CFG", $CFG);
$smarty->assign("message", $message);
$smarty->assign("mylist", $mylist);
$smarty->display('view.tpl');
