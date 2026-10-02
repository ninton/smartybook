<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/config-ketai.php';

/**
 * ini.phpで定義
 * @var string $siteName
 * @var string $home
 * @var array<int, array<string, string>> $categories
 */

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('categories', $categories);
$smarty->display('pages/chapter5_3/index.tpl');
