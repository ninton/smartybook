<?php

use App\PearStub\AuthStub as Auth;
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter5_5\src\SmartyPlugin\LoginFormFunction;

// ウェブサイト名
$siteName = 'Smarty for Designers';
// CSVファイル名
$csv = dirname(__DIR__) . '/data.csv';
// 画像ディレクトリ
$imageDir = './images/';
// ホーム
$home = 'index.php';
// 管理者ページ
$admin = 'admin.php';
// カテゴリ一覧
$categories = ['Study', 'Eating', 'Work'];

//暗号化形式とIDとパスワードを設定
$params = [
    'cryptType' => 'MD5',
    'users' => [
        'guest' => '084e0343a0486ff05530df6c705c8bb4',
    ],
];
//認証方法を決定
$oAuth = new Auth('Array', $params, 'displayLogin');
//ログアウトのスタイルを決定
if (isset($_GET['lo']) && $_GET['lo'] == 'ok') {
    $oAuth->logout();
}
//認証時に実行する関数
/**
 * @param string $username
 * @param int $status
 * @return void
 */
function displayLogin(string $username, int $status): void
{
    global $siteName, $admin, $home;

    $self = $_SERVER['PHP_SELF'];

    $errmsg = '';
    if ($status == -3) {
        $errmsg = 'ユーザー名もしくはパスワードが違います';
    }

    $smarty = new Smarty();
    $smarty->registerPlugin('function', 'login_form', LoginFormFunction::render(...));
    $smarty->assign('siteName', $siteName);
    $smarty->assign('admin', $admin);
    $smarty->assign('home', $home);
    $smarty->assign('self', $self);
    $smarty->assign('username', $username);
    $smarty->assign('errormsg', $errmsg);

    // 出力
    $smarty->display('pages/chapter5_5/login.tpl');
}
