<?php

use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/config-ketai.php';

/**
 * config/config.phpで定義
 * @var string $siteName
 * @var string $home
 * @var list<string> $categories
 * @var array<string, string> $iconMap
 *
 * config/config-ketai.phpで設定
 * @var string $carrierName
 * @var array<string, string> $layoutMap
 */

$categoryDataArr = [];
foreach ($categories as $category) {
    // 存在チェックやバリデーションを通過した安全なデータのみを詰める
    $categoryDataArr[] = [
        'name' => $category,
        'icon' => $iconMap[$category] ?? '',
        // URLもPHP側で適切にエンコードして用意する
        'url'  => 'contents.php?category=' . urlencode($category),
    ];
}

// ----- UIパーツ -----
$layoutName = $layoutMap[$carrierName];

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->setConfigDir(__DIR__ . '/config/smarty');
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('carrierName', $carrierName);
$smarty->assign('layoutName', $layoutName);
$smarty->assign('categoryDataArr', $categoryDataArr);
$smarty->display('pages/chapter5_3/index.tpl');
