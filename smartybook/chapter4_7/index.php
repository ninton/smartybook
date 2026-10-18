<?php

/**
 * アンケート入力フォーム
 *
 * GET index.php
 *  - フォーム表示
 *  - 項目は未入力状態
 *
 * GET index.php?action=form
 *  - フォーム表示
 *  - 項目はセッションから復元
 *
 * POST index.php?action=confirm
 *  - 入力内容をセッションに保存
 *  - 確認画面を表示
 *
 * POST index.php?action=submit
 *  - (本サンプルコードでは、入力内容の保存または管理者に送信などは未実装）
 *  - セッション変数をクリア
 *  - 送信完了画面を表示
 */
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter4_7\src\SmartyHelper;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
/** @var array{token_salt: string, app_id: string} $config */
$config = require_once __DIR__ . '/config/config.php';

// 都道府県などのメタデータをファイルから読み込む
$META['prefecture'] = SmartyHelper::array_load(__DIR__ . '/config/prefecture.txt');
$META['rating'] = SmartyHelper::assoc_load(__DIR__ . '/config/rating.txt');
$META['where'] = SmartyHelper::array_load(__DIR__ . '/config/where.txt');

// ----- インライン関数定義 -----
/**
 * @param array{token_salt: string, app_id: string} $config 設定情報
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $formFromSession セッションから復元したフォームデータ（未入力の場合は空配列）
 */
function form(array $config, array $meta, array $formFromSession = []): void
{
    // ----- データ準備 -----
    $now = time();

    $defaultForm = [
        'prefecture' => '',
        'rating' => '',
        'where_arr' => [],
        'startDate' => ['TimeStamp' => $now],
        'endDate_TimeStamp' => $now + 7 * 24 * 3600,
    ];

    if (empty($formFromSession)) {
        $form = $defaultForm;
        // 新規フォームの場合はセッションをクリア
        $_SESSION[$config['app_id']]['form'] = [];
    } else {
        $form = array_merge($defaultForm, $formFromSession);
        // 確認ページからの戻りの場合は、セッションをクリアしない
        // セッションをクリアしてしまうと、リロードした場合、確認ページから戻ったフォームの内容が消えてしまう
        // 書籍掲載コードの仕様のままとしました
    }

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $form);
    $smarty->display('pages/chapter4_7/form.tpl');
}
/**
 * @param array{token_salt: string, app_id: string} $config 設定情報
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $postVars POSTされたフォームデータ
 */
function confirm(array $config, array $meta, array $postVars): void
{
    // ----- 入力値受取・前処理 -----
    $form = $postVars;
    SmartyHelper::makeTimeStamp($form, ['field_array' => 'startDate']);
    SmartyHelper::makeTimeStamp($form, ['prefix' => 'endDate_']);
    $_SESSION[$config['app_id']]['form'] = $form;

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $form);
    $smarty->display('pages/chapter4_7/confirm.tpl');
}

/**
 * @param array{token_salt: string, app_id: string} $config 設定情報
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $formFromSession セッションから復元したフォームデータ
 */
function submit(array $config, array $meta, array $formFromSession): void
{
    // ----- 入力値受取・前処理 -----
    // 未実装

    // ----- メイン処理・データ操作 -----
    // 未実装

    // 最後にセッション変数をクリア
    $_SESSION[$config['app_id']]['form'] = [];

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $formFromSession);
    $smarty->display('pages/chapter4_7/thanks.tpl');
}

// セッションを開始、セッショントークンをチェックする
session_start();
$appId = $config['app_id'];
$token = md5($config['token_salt'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
if (!isset($_SESSION[$appId]['token']) || $_SESSION[$appId]['token'] != $token) {
    session_regenerate_id();
    $_SESSION[$appId] = [];
    $_SESSION[$appId]['token'] = $token;
}


/**
 * GET,action未設定|action=|action=index  新規フォーム
 * GET,action=form セッションから入力データを復元して、入力フォーム
 * POST,action=confirm 確認画面
 * POST,action=submit 送信完了画面
 */
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// GET と POST 以外は HTTP 405 を返して安全に終了する
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: GET, POST');
    die();
}

$action = $_REQUEST['action'] ?? 'index';
if ($action === '') {
    $action = 'index';
}

match ([$requestMethod, $action]) {
    ['GET', 'index'] => form($config, $META),
    ['GET', 'form'] => form($config, $META, $_SESSION[$appId]['form'] ?? []),
    ['POST', 'confirm'] => confirm($config, $META, $_POST),
    ['POST', 'submit'] => submit($config, $META, $_SESSION[$appId]['form'] ?? []),
    default => die(), // 不正な action はここでしっかりと弾く
};
