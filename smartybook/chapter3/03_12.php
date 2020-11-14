<?php

require_once("../vendor/autoload.php");
$smarty = new SmartyBC();
$siteName = "Smarty for Designers";
$body = "コンテンツ本文です。";
$smarty->assign("siteName", $siteName);
$smarty->assign("body", $body);
$smarty->display("03_12.tpl");
