<?php

use App\Smarty\AppSmarty as Smarty;
use Lib\PearStub\AuthStub as Auth;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/ini.php';
require_once __DIR__ . '/plugins/function.login_form.php';

/**
 * ini.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var string $admin
 * @var string[] $categories
 * @var Auth $oAuth
 */

$smarty = new Smarty();

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
    $smarty->display('pages/chapter5_5/admin.tpl');
}
