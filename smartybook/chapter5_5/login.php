<?php

require_once("ini.php");
require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
//出力
$smarty->display("login.tpl");
