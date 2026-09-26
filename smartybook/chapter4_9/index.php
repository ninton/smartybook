<?php

use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';

$smarty = new Smarty();

$smarty->display('index.tpl');
