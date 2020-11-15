<?php

require_once("ini.php");
require_once("../vendor/autoload.php");

$smarty = new Smarty();
$smarty->addPluginsDir(__DIR__ . '/plugins');

$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("admin", $admin);
$smarty->assign("categories", $categories);
//認証開始
$oAuth->start();
//認証が通った際の処理
if ($oAuth->getAuth()) {
// 出力
    $smarty->display("admin.tpl");
}
