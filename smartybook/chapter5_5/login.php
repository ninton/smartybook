<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/ini.php';
require_once __DIR__ . '/plugins/function.login_form.php';
/**
 * ini.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var string $admin
 */

$smarty = new Smarty();

$smarty->registerPlugin('function', 'login_form', smarty_function_login_form(...));

$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);

$smarty->assign('self', 'admin.php');
$smarty->assign('username', '');
$smarty->assign('errormsg', '');

//出力
$smarty->display('pages/chapter5_5/login.tpl');
