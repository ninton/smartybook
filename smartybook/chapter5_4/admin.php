<?php

require_once("ini.php");

$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("admin", $admin);
$smarty->assign("categories", $categories);
//出力
$smarty->display("admin.tpl");
