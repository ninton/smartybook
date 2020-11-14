<?php

require_once("../vendor/autoload.php");
$smarty = new SmartyBC();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
$name = "Smartyさん";
$type = "テンプレート・エンジン";
$smarty->assign("name", $name);
$smarty->assign("type", $type);
$smarty->display("03_02.tpl");
