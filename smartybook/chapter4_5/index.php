<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('hour', date('G'));
$smarty->display('pages/chapter4_5/index.tpl');
