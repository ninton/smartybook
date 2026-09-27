<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$smarty->assign('name', 'Smartyさん');
$smarty->display('pages/chapter3/03_01.tpl');
