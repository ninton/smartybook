<?php
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
$name = "Smartyさん";
$type = "テンプレート・エンジン";
$smarty->assign("name", $name);
$smarty->assign("type", $type);
$smarty->display("03_02.tpl");
?>