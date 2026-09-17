<?php

use Smarty\Smarty;

require_once("../../vendor/autoload.php");
$smarty = new Smarty();

// Smarty5準備: preg_match修飾子を登録
$smarty->registerPlugin('modifier', 'preg_match', preg_match(...));

$php = basename($_SERVER['SCRIPT_NAME']);
$tpl = preg_replace('/\.php$/', '.tpl', $php);
$smarty->display($tpl);
