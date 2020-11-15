<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->setTemplateDir("templates");
$smarty->setCompileDir("templates_c");
$smarty->display("03_07.tpl");
