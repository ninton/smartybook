<?php

require_once("ini.php");
require_once("../vendor/autoload.php");

$smarty = new Smarty();

$plugins_dir = $smarty->plugins_dir;
$plugins_dir[] = __DIR__ . '/plugins';
$smarty->plugins_dir = $plugins_dir;

$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);

$smarty->assign("self", "admin.php");
$smarty->assign("username", "");
$smarty->assign("errormsg", "");

//出力
$smarty->display("login.tpl");
