<?php

require_once("../vendor/autoload.php");
$smarty = new SmartyBC();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
$smarty->display("03_07.tpl");
