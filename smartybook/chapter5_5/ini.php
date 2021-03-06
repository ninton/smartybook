<?php

// phpcs:disable PSR1.Files.SideEffects

require_once __DIR__ . '/../vendor/autoload.php';

// PEAR内の PHP Strict Standards: PHP Deprecated: を抑制する
error_reporting(error_reporting() & ~E_STRICT & ~E_DEPRECATED);
// ウェブサイト名
$siteName = "Smarty for Designers";
// CSVファイル名
$csv = "data.csv";
// 画像ディレクトリ
$imageDir = "./images/";
// ホーム
$home = "index.php";
// 管理者ページ
$admin = "admin.php";
// カテゴリ一覧
$categories = array("Study", "Eating", "Work");

//暗号化形式とIDとパスワードを設定
$params = array(
    "cryptType" => "MD5",
    "users" => array(
        'guest' => '084e0343a0486ff05530df6c705c8bb4',
    )
);
//認証方法を決定
$oAuth = new Auth("Array", $params, "displayLogin");
//ログアウトのスタイルを決定
if (isset($_GET["lo"]) && $_GET["lo"] == "ok") {
    $oAuth->logout();
}
//認証時に実行する関数
function displayLogin($username, $status)
{
    $self = $_SERVER["PHP_SELF"];
    global $smarty;

    $errmsg = "";
    if ($status == -3) {
        $errmsg = "ユーザー名もしくはパスワードが違います";
    }

    $smarty->assign("self", $self);
    $smarty->assign("username", $username);
    $smarty->assign("errormsg", $errmsg);

    // 出力
    $smarty->display("login.tpl");
}
