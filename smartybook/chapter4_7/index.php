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
 *  - CSRFトークン検証
 *  - 入力内容をセッションに保存
 *  - 確認画面を表示
 *
 * POST index.php?action=submit
 *  - CSRFトークン検証
 *  - (本サンプルコードでは、入力内容の保存または管理者に送信などは未実装）
 *  - セッション変数をクリア（CSRFトークンもクリア）
 *  - 送信完了画面を表示
 */
use App\Smarty\AppSmarty as Smarty;
use Smarty\Exception as SmartyException;
use SmartyBook\chapter4_7\src\SmartyHelper;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
/** @var array{app_id: string} $config */
$config = require_once __DIR__ . '/config/config.php';

// 都道府県などのメタデータをファイルから読み込む
$META['prefecture'] = SmartyHelper::array_load(__DIR__ . '/config/prefecture.txt');
$META['rating'] = SmartyHelper::assoc_load(__DIR__ . '/config/rating.txt');
$META['where'] = SmartyHelper::array_load(__DIR__ . '/config/where.txt');

// ----- CSRF トークン用ヘルパー関数 -----

/**
 * CSRFトークンを取得（存在しない場合は生成してセッションに保存）
 */
function getCsrfToken(string $appId): string
{
    if (empty($_SESSION[$appId]['csrf_token'])) {
        $_SESSION[$appId]['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION[$appId]['csrf_token'];
}

/**
 * CSRFトークンを検証
 * csrf_token[]=x の形式も考慮して mixed とします
 */
function validateCsrfToken(string $appId, mixed $tokenFromPost): bool
{
    $storedToken = $_SESSION[$appId]['csrf_token'] ?? '';
    if (!is_string($tokenFromPost) || empty($storedToken) || empty($tokenFromPost)) {
        return false;
    }
    return hash_equals($storedToken, $tokenFromPost);
}

// ----- インライン関数定義 -----

/**
 * @param array{app_id: string} $config 設定情報
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $formFromSession セッションから復元したフォームデータ（未入力の場合は空配列）
 * @throws SmartyException
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
        // 新規フォームの場合はセッション内のフォームデータをクリア
        $_SESSION[$config['app_id']]['form'] = [];
    } else {
        $form = array_merge($defaultForm, $formFromSession);
        // 確認ページからの戻りの場合は、セッションをクリアしない
        // セッションをクリアしてしまうと、リロードした場合、確認ページから戻ったフォームの内容が消えてしまう
        // 書籍掲載コードの仕様のままとしました
    }

    // CSRFトークンを取得
    $csrfToken = getCsrfToken($config['app_id']);

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $form);
    $smarty->assign('csrf_token', $csrfToken);
    $smarty->display('pages/chapter4_7/form.tpl');
}

/**
 * @param array{app_id: string} $config 設定情報
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $postVars POSTされたフォームデータ
 * @throws SmartyException
 */
function confirm(array $config, array $meta, array $postVars): void
{
    $appId = $config['app_id'];

    // CSRF検証
    if (!validateCsrfToken($appId, $postVars['csrf_token'] ?? '')) {
        header('HTTP/1.1 400 Bad Request');
        die('不正なアクセスです。（CSRFトークン検証エラー）');
    }

    // ----- 入力値受取・前処理 -----
    $form = $postVars;
    SmartyHelper::makeTimeStamp($form, ['field_array' => 'startDate']);
    SmartyHelper::makeTimeStamp($form, ['prefix' => 'endDate_']);
    $_SESSION[$appId]['form'] = $form;

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $form);
    $smarty->assign('csrf_token', getCsrfToken($appId));
    $smarty->display('pages/chapter4_7/confirm.tpl');
}

/**
 * @param array{app_id: string} $config 設定情報
 * @param array<string, mixed> $meta メタデータ
 * @param array<string, mixed> $formFromSession セッションから復元したフォームデータ
 * @param array<string, mixed> $postVars POSTされたフォームデータ
 * @throws SmartyException
 */
function submit(array $config, array $meta, array $formFromSession, array $postVars): void
{
    // ----- 入力値受取・前処理 -----
    $appId = $config['app_id'];

    // CSRF検証
    if (!validateCsrfToken($appId, $postVars['csrf_token'] ?? '')) {
        header('HTTP/1.1 400 Bad Request');
        die('不正なアクセスです。セッションが切れたか、既に送信済みです。');
    }

    // ----- メイン処理・データ操作 -----
    // （DB保存やメール送信など）

    // 処理完了後にセッション（フォーム入力値＆CSRFトークン）をクリア
    unset($_SESSION[$appId]['form']);
    unset($_SESSION[$appId]['csrf_token']);

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('META', $meta);
    $smarty->assign('form', $formFromSession);
    $smarty->display('pages/chapter4_7/thanks.tpl');
}

// セッションを開始
session_start();
$appId = $config['app_id'];

/**
 * GET,action未設定|action=|action=index  新規フォーム
 * GET,action=form セッションから入力データを復元して、入力フォーム
 * POST,action=confirm 確認画面
 * POST,action=submit 送信完了画面
 */
$httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// GET と POST 以外は HTTP 405 を返して安全に終了する
if (!in_array($httpMethod, ['GET', 'POST'], true)) {
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: GET, POST');
    die();
}

$action = $_REQUEST['action'] ?? 'index';
if ($action === '') {
    $action = 'index';
}

match ([$httpMethod, $action]) {
    ['GET', 'index'] => form($config, $META),
    ['GET', 'form'] => form($config, $META, $_SESSION[$appId]['form'] ?? []),
    ['POST', 'confirm'] => confirm($config, $META, $_POST),
    ['POST', 'submit'] => submit($config, $META, $_SESSION[$appId]['form'] ?? [], $_POST),
    default => die(), // 不正な action はここでしっかりと弾く
};
