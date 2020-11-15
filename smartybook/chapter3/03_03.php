<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->setTemplateDir("templates");
$smarty->setCompileDir("templates_c");
$sites = array("Google", "MSN", "Yahoo!");
$smarty->assign("sites", $sites);
$smarty->display("03_03.tpl");
