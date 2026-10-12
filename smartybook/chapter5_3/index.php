<?php

use App\PearStub\NetUserAgentMobileCommonStub;
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter5_3\src\KetaiSetUp;
use SmartyBook\chapter5_3\src\NetUserAgentMobileMapper;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';

/**
 * config/config.phpで定義
 * @var string $siteName
 * @var string $home
 * @var list<string> $categories
 * @var array<string, string> $iconMap
 * @var array<string, string> $layoutMap
 */

// ----- 入力値受取・前処理 -----
$agentDto = NetUserAgentMobileMapper::toDto(new NetUserAgentMobileCommonStub());
KetaiSetUp::contentType($agentDto['rawCarrier']);
KetaiSetUp::outputHandler($agentDto['carrierName']);

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
$layoutName = $layoutMap[$agentDto['carrierName']];

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->setConfigDir(__DIR__ . '/config/smarty');
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('carrierName', $agentDto['carrierName']);
$smarty->assign('layoutName', $layoutName);
$smarty->assign('categoryDataArr', $categoryDataArr);
$smarty->display('pages/chapter5_3/index.tpl');
