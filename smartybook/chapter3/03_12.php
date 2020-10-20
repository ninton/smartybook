<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$siteName = "Smarty for Designers";
$body = "コンテンツ本文です。";
$smarty->assign("siteName", $siteName);
$smarty->assign("body", $body);
$smarty->display("03_12.tpl");
?>