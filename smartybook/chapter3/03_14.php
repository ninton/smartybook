<?php

require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$result = mt_rand(1, 3);
$smarty->assign("result", $result);
$smarty->display("03_14.tpl");
