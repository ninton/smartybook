<?php

require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
$sites = array("Google", "MSN", "Yahoo!");
$smarty->assign("sites", $sites);
$smarty->display("03_03.tpl");
