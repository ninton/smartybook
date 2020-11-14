<?php

require_once('../vendor/autoload.php');
$smarty = new SmartyBC();
$smarty->assign('hour', date("G"));
$smarty->display('index.tpl');
