<?php

use Smarty\Smarty;

require_once '../../vendor/autoload.php';

$smarty = new Smarty();

$smarty->display('index.tpl');
