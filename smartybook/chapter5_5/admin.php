<?php

use App\PearStub\AuthStub as Auth;
use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/ini.php';
/**
 * ini.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var string $admin
 * @var string[] $categories
 * @var Auth $oAuth
 */

// 認証開始
$oAuth->start();
if (!$oAuth->getAuth()) {
    // 認証失敗
    // ini.php の displayLogin 関数が呼ばれるので、ここでは何も出力しない
    return;
}

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
$smarty->assign('categories', $categories);
$smarty->display('pages/chapter5_5/admin.tpl');
