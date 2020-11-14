<?php

// 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
// 常に410エラーです

//  GET show=
//    GET show=form
//    GET show=preview
// POST cmdPreview=
// POST cmdSave
// POST cmdForm=
//    POST cmdLoad=
require_once('./_read/inc.php');

use SmartyBook\chapter5_6\_read\classes\App;
use SmartyBook\chapter5_6\_read\classes\AppAmazon;
use SmartyBook\chapter5_6\_read\classes\AppSmarty;
use SmartyBook\chapter5_6\_read\classes\MyListManager;

$show = '';
if (isset($_GET['show'])) {
    $show = $_GET['show'];
}

switch (strtolower($_SERVER['REQUEST_METHOD'])) {
    case 'get':
        switch ($show) {
            case '':
            case 'preview':
                if (empty($_REQUEST['ListId'])) {
                    $_REQUEST['ListId'] = 1;
                }
                $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
                $mylist = $mylistmgr->read($_REQUEST['ListId']);
                if ($mylist === null) {
                    die('file read error');
                }

                $appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['secret_access_key'], $CFG['associate_tag']);
                $options['ResponseGroup'] = 'Medium';
                $message = $appAmazon->ItemLookup($mylist->getASINs(), $options, $Item_arr);
                $mylist->setItems($Item_arr);

                $smarty = new AppSmarty();
                $smarty->assign("CFG", $CFG);
                $smarty->assign("message", $message);
                $smarty->assign("mylist", $mylist);
                $smarty->display('admin_preview.tpl');
                break;

            case 'form':
                $message = '';
                $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
                $mylist = $mylistmgr->read($_REQUEST['ListId']);
                if ($mylist === null) {
                    die('file read error');
                }
                $smarty = new AppSmarty();
                $smarty->assign("CFG", $CFG);
                $smarty->assign("message", $message);
                $smarty->assign("mylist", $mylist);
                $smarty->display('admin_form.tpl');
                break;

            default:
                break;
        }
        break;

    case 'post':
        switch (App::getCmd()) {
            case 'cmdSave':
                $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
                $mylist = $mylistmgr->read($_REQUEST['ListId']);
                $mylist->input($_POST);
                $appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['secret_access_key'], $CFG['associate_tag']);
                $options['ResponseGroup'] = 'Small';
                $message = $appAmazon->ItemLookup($mylist->getASINs(), $options, $item_arr);
                $mylist->setItems($item_arr);
                if ($mylist === null) {
                    die('file read error');
                }

                if ($message != '') {
                    $smarty = new AppSmarty();
                    $smarty->assign("CFG", $CFG);
                    $smarty->assign("message", $message);
                    $smarty->assign("mylist", $mylist);
                    $smarty->display('admin_form.tpl');
                } else {
                    $mylistmgr->write($mylist);
                    App::redirect('?show=preview&ListId=' . $_REQUEST['ListId']);
                }
                break;

            case 'cmdCancel':
                App::redirect('?show=preview&ListId=' . $_REQUEST['ListId']);
                break;

            default:
                break;
        }
        break;

    default:
        break;
}
