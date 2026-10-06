<?php

namespace SmartyBook\chapter5_6;

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

// ----- インライン関数定義 -----
/**
 * @param array<string, mixed> $config
 */
function preview(array $config): void
{
    // ----- メイン処理・データ操作 -----
    $myListRepository = new MyListRepository($config['max_items'], $config['my_list_dir']);
    $myList = $myListRepository->read();
    if ($myList === null) {
        die('file read error');
    }

    $appAmazon = new AppAmazon($config['access_key_id'], $config['secret_access_key'], $config['associate_tag']);
    $options['ResponseGroup'] = 'Medium';
    $itemArr = [];
    $message = $appAmazon->ItemLookup($myList->getASINs(), $options, $itemArr);
    $myList->setItems($itemArr);

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new AppSmarty();
    $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
    $smarty->assign('message', $message);
    $smarty->assign('myList', $myList);
    $smarty->display('pages/chapter5_6/admin_preview.tpl');
}

/**
 * @param array<string, mixed> $config
 */
function form(array $config): void
{
    // ----- メイン処理・データ操作 -----
    $message = '';
    $myListRepository = new MyListRepository($config['max_items'], $config['my_list_dir']);
    $myList = $myListRepository->read();
    if ($myList === null) {
        die('file read error');
    }

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new AppSmarty();
    $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
    $smarty->assign('max_items', $config['max_items']);
    $smarty->assign('message', $message);
    $smarty->assign('myList', $myList);
    $smarty->display('pages/chapter5_6/admin_form.tpl');
}

/**
 * @param array<string, mixed> $config
 * @param array<string, mixed> $postVars
 */
function save(array $config, array $postVars): void
{
    // ----- メイン処理・データ操作 -----
    $myListRepository = new MyListRepository($config['max_items'], $config['my_list_dir']);
    $myList = $myListRepository->read();
    if ($myList === null) {
        die('file read error');
    }
    $myList->input($postVars);
    $appAmazon = new AppAmazon($config['access_key_id'], $config['secret_access_key'], $config['associate_tag']);
    $options['ResponseGroup'] = 'Small';
    $itemArr = [];
    $message = $appAmazon->ItemLookup($myList->getASINs(), $options, $itemArr);

    if ($message != '') {
        // ----- テンプレートエンジンの初期化とアサイン・描画 -----
        $smarty = new AppSmarty();
        $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
        $smarty->assign('max_items', $config['max_items']);
        $smarty->assign('message', $message);
        $smarty->assign('myList', $myList);
        $smarty->display('pages/chapter5_6/admin_form.tpl');
    } else {
        $myListRepository->write($myList);
        header('Location: ?action=preview');
    }
}

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
        preview($config);
        break;

    case 'get.form':
        form($config);
        break;

    case 'post.save':
        save($config, $_POST);
        break;
}
