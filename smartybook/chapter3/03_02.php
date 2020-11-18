<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->setTemplateDir("templates");
$smarty->setCompileDir("templates_c");
$name = "Smartyさん";
$type = "テンプレート・エンジン";
$smarty->assign("name", $name);
$smarty->assign("type", $type);
$smarty->display("03_02.tpl");
