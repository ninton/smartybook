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
require_once __DIR__ . '/config.php';

// 都道府県などのメタデータをファイルから読み込む
$META['prefecture'] = array_load('prefecture.txt');
$META['rating'] = assoc_load('rating.txt');
$META['where'] = array_load('where.txt');

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
        $form = [];
        $_SESSION[APPID]['form'] = [];
        $tpl = 'form.tpl';
        break;
    case 'GET.form':
        $form = $_SESSION[APPID]['form'];
        $tpl = 'form.tpl';
        break;
    case 'POST.confirm':
        $form = $_POST;
        $tpl = 'confirm.tpl';
        break;
    case 'POST.submit':
        $form = $_SESSION[APPID]['form'];
        $tpl = 'thanks.tpl';
        break;
    default:
        die();
}

if (!isset($form['prefecture'])) {
    $form['prefecture'] = '';
}

if (!isset($form['rating'])) {
    $form['rating'] = '';
}

if (!isset($form['where_arr'])) {
    $form['where_arr'] = [];
}

// {html_select_date/time}用タイムスタンプを計算する
$now = time();
if (isset($form['startDate'])) {
    makeTimeStamp($form, ['field_array' => 'startDate']);
} else {
    $form['startDate']['TimeStamp'] = $now;
}

if (isset($form['endDate_Year'])) {
    makeTimeStamp($form, ['prefix' => 'endDate_']);
} else {
    $form['endDate_TimeStamp'] = $now + 7 * 24 * 3600;
}

$smarty = new Smarty();
$smarty->assign('META', $META);
$smarty->assign('form', $form);
$smarty->display('pages/chapter4_7/' . $tpl);

switch ("$requestMethod.$action") {
    case 'POST.confirm':
        $_SESSION[APPID]['form'] = $form;
        break;
    case 'POST.submit':
        $_SESSION[APPID]['form'] = [];
        break;

}
