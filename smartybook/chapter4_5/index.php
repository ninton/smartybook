<?php

require_once('../smarty/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->assign('hour', date("G"));
$smarty->display('index.tpl');
