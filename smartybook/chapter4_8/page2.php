<?php

require_once('../vendor/autoload.php');
$smarty = new SmartyBC();
$php = basename($_SERVER['SCRIPT_NAME']);
$tpl = preg_replace('/\.php$/', '.tpl', $php);
$smarty->display($tpl);
