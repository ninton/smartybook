<?php

require_once("ini.php");
require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("categories", $categories);
$smarty->display("index.tpl");
