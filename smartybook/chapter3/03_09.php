<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("text", "'> Good Web = PHP & Smarty + Idea'");
$smarty->display("03_09.tpl");
?>