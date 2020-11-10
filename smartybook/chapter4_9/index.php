<?php

require_once('../vendor/autoload.php');

$smarty = new Smarty();
$smarty->plugins_dir[] = __DIR__;
$smarty->display('index.tpl');
