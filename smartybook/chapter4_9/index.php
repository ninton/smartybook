<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';

$smarty = new Smarty();

$smarty->display('pages/chapter4_9/index.tpl');
