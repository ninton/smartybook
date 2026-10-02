<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';
/**
 * config/config.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var string $admin
 * @var list<string> $categories
 */

// テンプレートエンジン初期化・変数アサイン・描画
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
$smarty->assign('categories', $categories);
$smarty->display('pages/chapter5_4/admin.tpl');
