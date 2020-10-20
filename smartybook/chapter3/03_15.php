<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$name = array("八代", "国枝", "大石");
$height = array("167", "156", "182", "200");
$smarty->assign("name", $name);
$smarty->assign("height", $height);
$smarty->display("03_15.tpl");
?>