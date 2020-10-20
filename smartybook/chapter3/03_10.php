<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("myDate", time());
$smarty->display("03_10.tpl");
?>