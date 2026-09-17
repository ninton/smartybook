<?php

require_once("ini.php");
use Smarty\Smarty;

require_once("../../vendor/autoload.php");

$smarty = new Smarty();

include_once(__DIR__ . '/plugins/function.login_form.php');
$smarty->registerPlugin('function', 'login_form', smarty_function_login_form(...));

$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("admin", $admin);

$smarty->assign("self", "admin.php");
$smarty->assign("username", "");
$smarty->assign("errormsg", "");

//出力
$smarty->display("login.tpl");
