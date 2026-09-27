<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';

$smarty = new Smarty();

$smarty->display('index.tpl');
