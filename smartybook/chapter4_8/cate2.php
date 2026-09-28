<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
$smarty = new Smarty();

// Smarty5準備: preg_match修飾子を登録
$smarty->registerPlugin('modifier', 'preg_match', preg_match(...));

$php = basename($_SERVER['SCRIPT_NAME']);
$tpl = preg_replace('/\.php$/', '.tpl', $php);
$smarty->display('pages/chapter4_8/' . $tpl);
