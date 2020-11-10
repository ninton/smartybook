<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->assign("bgColor", "#ff0066");
$smarty->display("03_22.tpl");
