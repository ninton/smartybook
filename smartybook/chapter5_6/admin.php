<?php

namespace SmartyBook\chapter5_6;

/**
 * @note 2020年3月で、本プログラムで使っているAmazon_ECSのAPIは廃止となりました。
 * スタブに置き換えています
 */

use App\PearStub\ServicesAmazonStub;
use App\Smarty\AppSmarty;
use App\Smarty\Plugin\MbTruncateModifier;
use Smarty\Exception as SmartyException;
use SmartyBook\chapter5_6\src\AmazonServicesWrapper;
use SmartyBook\chapter5_6\src\MyList;
use SmartyBook\chapter5_6\src\MyListRepository;
use SmartyBook\chapter5_6\src\MyListViewModel;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
$config = require_once __DIR__ . '/config/config.php';

// ----- インライン関数定義 -----
/**
 * @param array<string, mixed> $config
 * @throws SmartyException
 */
function preview(array $config): void
{
    // ----- メイン処理・データ操作 -----
    $myListRepository = new MyListRepository();
    $myList = $myListRepository->read($config['storage_path']);
    if ($myList === null) {
        die('file read error');
    }

    $amazonServicesWrapper = new AmazonServicesWrapper(new ServicesAmazonStub($config['access_key_id'], $config['secret_access_key'], $config['associate_tag']));
    $options['ResponseGroup'] = 'Medium';
    $itemArr = [];
    $message = $amazonServicesWrapper->ItemLookup($myList->getASINs(), $options, $itemArr);
    $myListViewModel = MyListViewModel::create($myList, $itemArr);

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new AppSmarty();
    $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
    $smarty->assign('message', $message);
    $smarty->assign('myList', $myListViewModel);
    $smarty->display('pages/chapter5_6/admin_preview.tpl');
}

/**
 * @param array<string, mixed> $config
 * @throws SmartyException
 */
function form(array $config): void
{
    // ----- メイン処理・データ操作 -----
    $message = '';
    $myListRepository = new MyListRepository();
    $myList = $myListRepository->read($config['storage_path']);
    if ($myList === null) {
        die('file read error');
    }

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new AppSmarty();
    $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
    $smarty->assign('max_items', MyList::MAX_ITEMS);
    $smarty->assign('message', $message);
    $smarty->assign('myList', $myList);
    $smarty->display('pages/chapter5_6/admin_form.tpl');
}

/**
 * @param array<string, mixed> $config
 * @param array<string, mixed> $postVars
 * @throws SmartyException
 */
function save(array $config, array $postVars): void
{
    // ----- 入力値受取・前処理 -----
    if (count($postVars['detail_arr']) > MyList::MAX_ITEMS) {
        die('detail_arr cannot have more than ' . MyList::MAX_ITEMS . ' items.');
    }

    // ----- メイン処理・データ操作 -----
    $myListRepository = new MyListRepository();
    $myList = $myListRepository->read($config['storage_path']);
    if ($myList === null) {
        die('file read error');
    }

    $myList = new MyList(
        $postVars['ListName'] ?? '',
        $postVars['NickName'] ?? '',
        $postVars['detail_arr'] ?? [],
    );
    $amazonServicesWrapper = new AmazonServicesWrapper(new ServicesAmazonStub($config['access_key_id'], $config['secret_access_key'], $config['associate_tag']));
    $options['ResponseGroup'] = 'Small';
    $itemArr = [];
    $message = $amazonServicesWrapper->ItemLookup($myList->getASINs(), $options, $itemArr);

    if ($message != '') {
        // ----- テンプレートエンジンの初期化とアサイン・描画 -----
        $smarty = new AppSmarty();
        $smarty->registerPlugin('modifier', 'mb_truncate', MbTruncateModifier::truncate(...));
        $smarty->assign('max_items', MyList::MAX_ITEMS);
        $smarty->assign('message', $message);
        $smarty->assign('myList', $myList);
        $smarty->display('pages/chapter5_6/admin_form.tpl');
    } else {
        $myListRepository->write($config['storage_path'], $myList);
        header('Location: ?action=preview');
    }
}

/**
 * GET,action未設定|action=|action=preview プレビュー表示
 * GET,action=form 入力フォーム表示
 * POST,action=save 保存処理
 */
$httpMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

// GET と POST 以外は HTTP 405 を返して安全に終了する
if (!in_array($httpMethod, ['GET', 'POST'], true)) {
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: GET, POST');
    die();
}

$action = $_REQUEST['action'] ?? 'preview';
if ($action === '') {
    $action = 'preview';
}

match ([$httpMethod, $action]) {
    ['GET', 'preview'] => preview($config),
    ['GET', 'form'] => form($config),
    ['POST', 'save'] => save($config, $_POST),
    default => die(), // 不正な action はここでしっかりと弾く
};
