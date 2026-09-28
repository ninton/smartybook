<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('hour', date('G'));
$smarty->display('pages/chapter4_5/index.tpl');
