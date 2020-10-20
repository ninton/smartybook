<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
// 連想配列
$sites = array("name" => "Google", "url" => "http://www.google.com/");
$smarty->assign("sites", $sites);
$smarty->display("03_05.tpl");
?>