<?php

require_once("ini.php");
require_once("../vendor/autoload.php");
$smarty = new SmartyBC();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("admin", $admin);
$smarty->assign("categories", $categories);
//出力
$smarty->display("admin.tpl");
