<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->setTemplateDir("templates");
$smarty->setCompileDir("templates_c");
$sites = array("Google", "MSN", array("Yahoo!", "Yahoo!Japan"));
$smarty->assign("sites", $sites);
$smarty->display("03_04.tpl");
