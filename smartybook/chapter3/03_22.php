<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('bgColor', '#ff0066');
$smarty->display('03_22.tpl');
