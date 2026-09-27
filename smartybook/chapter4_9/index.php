<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

$smarty = new Smarty();

$smarty->display('pages/chapter4_9/index.tpl');
