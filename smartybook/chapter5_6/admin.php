<?php

namespace SmartyBook\chapter5_6;

/**
 * @note 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * スタブに置き換えています
 */

use App\Smarty\AppSmarty;
use SmartyBook\chapter5_6\src\AppAmazon;
use SmartyBook\chapter5_6\src\MyListManager;
use SmartyBook\chapter5_6\src\SmartyPlugin\MbTruncateModifier;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';

// ----- インライン関数定義 -----
/**
 * @param array<string, mixed> $CFG
 */
function preview(array $CFG): void
{
    // ----- メイン処理・データ操作 -----
    $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
    $myList = $mylistmgr->read();
    if ($myList === null) {
        die('file read error');
    }

    $appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['secret_access_key'], $CFG['associate_tag']);
    $options['ResponseGroup'] = 'Medium';
    $itemArr = [];
    $message = $appAmazon->ItemLookup($myList->getASINs(), $options, $itemArr);
    $myList->setItems($itemArr);

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new AppSmarty();
    $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
    $smarty->assign('CFG', $CFG);
    $smarty->assign('message', $message);
    $smarty->assign('mylist', $myList);
    $smarty->display('pages/chapter5_6/admin_preview.tpl');
}

/**
 * @param array<string, mixed> $CFG
 */
function form(array $CFG): void
{
    // ----- メイン処理・データ操作 -----
    $message = '';
    $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
    $myList = $mylistmgr->read();
    if ($myList === null) {
        die('file read error');
    }

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new AppSmarty();
    $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
    $smarty->assign('CFG', $CFG);
    $smarty->assign('message', $message);
    $smarty->assign('mylist', $myList);
    $smarty->display('pages/chapter5_6/admin_form.tpl');
}

/**
 * @param array<string, mixed> $CFG
 * @param array<string, mixed> $postVars
 */
function save(array $CFG, array $postVars): void
{
    // ----- メイン処理・データ操作 -----
    $mylistmgr = new MyListManager($CFG['max_items'], $CFG['mylist_dir']);
    $myList = $mylistmgr->read();
    if ($myList === null) {
        die('file read error');
    }
    $myList->input($postVars);
    $appAmazon = new AppAmazon($CFG['access_key_id'], $CFG['secret_access_key'], $CFG['associate_tag']);
    $options['ResponseGroup'] = 'Small';
    $itemArr = [];
    $message = $appAmazon->ItemLookup($myList->getASINs(), $options, $itemArr);

    if ($message != '') {
        // ----- テンプレートエンジンの初期化とアサイン・描画 -----
        $smarty = new AppSmarty();
        $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
        $smarty->assign('CFG', $CFG);
        $smarty->assign('message', $message);
        $smarty->assign('mylist', $myList);
        $smarty->display('pages/chapter5_6/admin_form.tpl');
    } else {
        // リファクタリング中の暫定対応。不要になったら削除する
        if (isset($myList->item_arr)) {
            unset($myList->item_arr);
        }
        $mylistmgr->write($myList);
        header('Location: ?action=preview');
    }
}

/**
 * @var array<string, mixed> $CFG
 */

// GET action=preview プレビュー表示
// GET action=form 入力フォーム表示
// POST action=save 保存処理
$rawAction = $_REQUEST['action'] ?? null;

// 未指定(null)の場合は 'preview'、文字列の場合はそのまま、配列等は null扱い
$action = match (true) {
    $rawAction === null => 'preview',
    is_string($rawAction) => $rawAction,
    default => null,
};

$method = strtolower($_SERVER['REQUEST_METHOD']);

switch ("$method.$action") {
    case 'get.preview':
        preview($CFG);
        break;

    case 'get.form':
        form($CFG);
        break;

    case 'post.save':
        save($CFG, $_POST);
        break;
}
