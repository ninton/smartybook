<?php

require_once('../vendor/autoload.php');

$smarty = new Smarty();

$plugins_dir = $smarty->plugins_dir;
$plugins_dir[] = __DIR__;
$smarty->plugins_dir = $plugins_dir;

$smarty->display('index.tpl');
