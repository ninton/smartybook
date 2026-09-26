<?php

use Smarty\Smarty;

require_once '../../vendor/autoload.php';
$smarty = new Smarty();
$smarty->assign('hour', date('G'));
$smarty->display('index.tpl');
