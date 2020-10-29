<?php

require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
$smarty->assign("name", "Smartyさん");
$smarty->display("03_01.tpl");
