<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('bgColor', '#ff0066');
$smarty->display('pages/chapter3/03_22.tpl');
