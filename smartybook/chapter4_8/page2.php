<?php

require_once('../smarty/libs/Smarty.class.php');
$smarty = new Smarty();
$php = basename($_SERVER['SCRIPT_NAME']);
$tpl = preg_replace('/\.php$/', '.tpl', $php);
$smarty->display($tpl);
