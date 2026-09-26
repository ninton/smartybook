<?php

require_once 'ini.php';
use Lib\PearStub\AuthStub as Auth;
use Smarty\Smarty;

require_once '../../vendor/autoload.php';

/** @var string $siteName */
/** @var string $home */
/** @var string $admin */
/** @var string[] $categories */
/** @var Auth $oAuth */

$smarty = new Smarty();

include_once __DIR__ . '/plugins/function.login_form.php';
$smarty->registerPlugin('function', 'login_form', smarty_function_login_form(...));

$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
$smarty->assign('categories', $categories);
//認証開始
$oAuth->start();
//認証が通った際の処理
if ($oAuth->getAuth()) {
    // 出力
    $smarty->display('admin.tpl');
}
