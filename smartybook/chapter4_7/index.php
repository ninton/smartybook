<?php

require_once('../vendor/autoload.php');
require_once('./funcs.php');
require_once('./config.php');
// 都道府県などのメタデータをファイルから読み込む
$META['prefecture'] = array_load("prefecture.txt");
$META['rating'    ] = assoc_load("rating.txt");
$META['where'     ] = array_load("where.txt");
// セッションを開始、セッショントークンをチェックする
session_start();
$token = md5(TOKEN_SALT . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
if (!isset($_SESSION[APPID]['token']) || $_SESSION[APPID]['token'] != $token) {
    session_regenerate_id();
    $_SESSION[APPID] = array();
    $_SESSION[APPID]['token'] = $token;
}

$action = '';
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
}
// actionを調べて、表示するテンプレートを切り替える
switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
    case 'POST':
        switch ($action) {
            case 'confirm':
                $_SESSION[APPID]['form'] = $_POST;
                $tpl = "confirm.tpl";
                break;

            case 'submit':
                $tpl = "thanks.tpl";
                break;

            default:
                die();
        }

        break;
    default:
        switch ($action) {
            case '':
                $_SESSION[APPID]['form'] = [
                    'rating'     => '',
                    'where_arr'  => [],
                ];
                $tpl = "form.tpl";
                break;

            case 'form':
                $tpl = "form.tpl";
                break;

            default:
                die();
        }

        break;
}

// {html_select_date/time}用タイムスタンプを計算する
$now = time();
if (! empty($_SESSION[APPID]['form']['startDate'])) {
    makeTimeStamp($_SESSION[APPID]['form'], array('field_array' => 'startDate'));
} else {
    $_SESSION[APPID]['form']['startDate']['TimeStamp'] = $now;
    ;
}
if (! empty($_SESSION[APPID]['form']['endDate_Year'])) {
    makeTimeStamp($_SESSION[APPID]['form'], array('prefix' => 'endDate_'));
} else {
    $_SESSION[APPID]['form']['endDate_TimeStamp'] = $now + 7 * 24 * 3600;
}
$smarty = new SmartyBC();
$smarty->assign("META", $META);
$smarty->assign("form", $_SESSION[APPID]['form']);
$smarty->display($tpl);
// 送信完了後、セッション変数をクリアする
switch ($action) {
    case 'submit':
        $_SESSION[APPID]['form'] = array();
        break;

    default:
        break;
}
