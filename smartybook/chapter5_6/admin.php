<?php

/**
 * @note 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * スタブに置き換えています
 */

use App\Smarty\AppSmarty;
use SmartyBook\chapter5_6\src\App;
use SmartyBook\chapter5_6\src\AppAmazon;
use SmartyBook\chapter5_6\src\MyListManager;
use SmartyBook\chapter5_6\src\SmartyPlugin\MbTruncateModifier;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';

/**
 * @var array<string, mixed> $CFG
 */

// GET show=
// GET show=form
// GET show=preview
// POST cmdPreview=
// POST cmdSave
// POST cmdForm=
// POST cmdLoad=

$show = '';
if (isset($_GET['show'])) {
    $show = $_GET['show'];
}

switch (strtolower($_SERVER['REQUEST_METHOD'])) {
    case 'get':
        switch ($show) {
            case '':
            case 'preview':
                // ----- メイン処理・データ操作 -----
                $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
                $mylist = $mylistmgr->read();
                if ($mylist === null) {
                    die('file read error');
                }

                $appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['secret_access_key'], $CFG['associate_tag']);
                $options['ResponseGroup'] = 'Medium';
                $Item_arr = [];
                $message = $appAmazon->ItemLookup($mylist->getASINs(), $options, $Item_arr);
                $mylist->setItems($Item_arr);

                // ----- テンプレートエンジンの初期化とアサイン・描画 -----
                $smarty = new AppSmarty();
                $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
                $smarty->assign('CFG', $CFG);
                $smarty->assign('message', $message);
                $smarty->assign('mylist', $mylist);
                $smarty->display('pages/chapter5_6/admin_preview.tpl');
                break;

            case 'form':
                // ----- メイン処理・データ操作 -----
                $message = '';
                $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
                $mylist = $mylistmgr->read();
                if ($mylist === null) {
                    die('file read error');
                }

                // ----- テンプレートエンジンの初期化とアサイン・描画 -----
                $smarty = new AppSmarty();
                $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
                $smarty->assign('CFG', $CFG);
                $smarty->assign('message', $message);
                $smarty->assign('mylist', $mylist);
                $smarty->display('pages/chapter5_6/admin_form.tpl');
                break;

            default:
                break;
        }
        break;

    case 'post':
        switch (App::getCmd()) {
            case 'cmdSave':
                // ----- メイン処理・データ操作 -----
                $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
                $mylist = $mylistmgr->read();
                $mylist->input($_POST);
                $appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['secret_access_key'], $CFG['associate_tag']);
                $options['ResponseGroup'] = 'Small';
                $item_arr = [];
                $message = $appAmazon->ItemLookup($mylist->getASINs(), $options, $item_arr);
                if ($mylist === null) {
                    die('file read error');
                }

                if ($message != '') {
                    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
                    $smarty = new AppSmarty();
                    $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
                    $smarty->assign('CFG', $CFG);
                    $smarty->assign('message', $message);
                    $smarty->assign('mylist', $mylist);
                    $smarty->display('pages/chapter5_6/admin_form.tpl');
                } else {
                    // リファクタリング中の暫定対応。不要になったら削除する
                    if (isset($mylist->item_arr)) {
                        unset($mylist->item_arr);
                    }
                    $mylistmgr->write($mylist);
                    header('Location: ?show=preview');
                }
                break;

            case 'cmdCancel':
                header('Location: ?show=preview');
                break;

            default:
                break;
        }
        break;

    default:
        break;
}
