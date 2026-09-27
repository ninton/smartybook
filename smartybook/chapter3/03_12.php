<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/../../bootstrap/app.php';
$smarty = new Smarty();
$siteName = 'Smarty for Designers';
$body = 'コンテンツ本文です。';
$smarty->assign('siteName', $siteName);
$smarty->assign('body', $body);
$smarty->display('pages/chapter3/03_12.tpl');
