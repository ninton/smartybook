<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->setTemplateDir("templates");
$smarty->setCompileDir("templates_c");
$smarty->assign("name", "Smartyさん");
$smarty->display("03_01.tpl");
