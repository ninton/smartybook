<?php

require_once("../vendor/autoload.php");
$smarty = new SmartyBC();
$result = mt_rand(1, 3);
$smarty->assign("result", $result);
$smarty->display("03_14.tpl");
