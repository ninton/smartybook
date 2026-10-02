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

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/funcs.php';
require_once __DIR__ . '/config/config.php';

// 都道府県などのメタデータをファイルから読み込む
$META['prefecture'] = array_load(__DIR__ . '/config/prefecture.txt');
$META['rating'] = assoc_load(__DIR__ . '/config/rating.txt');
$META['where'] = array_load(__DIR__ . '/config/where.txt');

// ----- インライン関数定義 -----
/**
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $formFromSession セッションから復元したフォームデータ（未入力の場合は空配列）
 */
function form(array $meta, array $formFromSession = []): void
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
        $_SESSION[APPID]['form'] = [];
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
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $postVars POSTされたフォームデータ
 */
function confirm(array $meta, array $postVars): void
{
    // ----- 入力値受取・前処理 -----
    $form = $postVars;
    makeTimeStamp($form, ['field_array' => 'startDate']);
    makeTimeStamp($form, ['prefix' => 'endDate_']);
    $_SESSION[APPID]['form'] = $form;

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $form);
    $smarty->display('pages/chapter4_7/confirm.tpl');
}

/**
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $formFromSession セッションから復元したフォームデータ
 */
function submit(array $meta, array $formFromSession): void
{
    // ----- 入力値受取・前処理 -----
    // 未実装

    // ----- メイン処理・データ操作 -----
    // 未実装

    // 最後にセッション変数をクリア
    $_SESSION[APPID]['form'] = [];

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $formFromSession);
    $smarty->display('pages/chapter4_7/thanks.tpl');
}

// セッションを開始、セッショントークンをチェックする
session_start();
$token = md5(TOKEN_SALT . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
if (!isset($_SESSION[APPID]['token']) || $_SESSION[APPID]['token'] != $token) {
    session_regenerate_id();
    $_SESSION[APPID] = [];
    $_SESSION[APPID]['token'] = $token;
}

$requestMethod = strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' ? 'POST' : 'GET';
$action = $_REQUEST['action'] ?? '';
if (!is_string($action)) {
    die();
}

switch ("$requestMethod.$action") {
    case 'GET.':
        form($META);
        break;
    case 'GET.form':
        form($META, $_SESSION[APPID]['form'] ?? []);
        break;
    case 'POST.confirm':
        confirm($META, $_POST);
        break;
    case 'POST.submit':
        submit($META, $_SESSION[APPID]['form'] ?? []);
        break;
    default:
        die();
}
