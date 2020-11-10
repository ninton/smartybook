<?php

require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->assign("myDate", time());
$smarty->display("03_10.tpl");
