<?php

use App\PearStub\NetUserAgentMobileCommonStub;
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter5_3\src\KetaiSetUp;
use SmartyBook\chapter5_3\src\NetUserAgentMobileMapper;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
$config = require_once __DIR__ . '/config/config.php';

// ----- 入力値受取・前処理 -----
$agentDto = NetUserAgentMobileMapper::toDto(new NetUserAgentMobileCommonStub());
KetaiSetUp::contentType($agentDto['rawCarrier']);
KetaiSetUp::outputHandler($agentDto['platformType']);

$categoryDataArr = [];
foreach ($config['categories'] as $category) {
    // 存在チェックやバリデーションを通過した安全なデータのみを詰める
    $categoryDataArr[] = [
        'name' => $category,
        'icon' => $config['categoryToIconMap'][$category] ?? '',
        // URLもPHP側で適切にエンコードして用意する
        'url'  => 'contents.php?category=' . urlencode($category),
    ];
}

// ----- UIパーツ -----
$layoutName = $config['platformTypeToLayoutMap'][$agentDto['platformType']];

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->setConfigDir(__DIR__ . '/config/smarty');
$smarty->assign('siteName', $config['siteName']);
$smarty->assign('home', $config['home']);
$smarty->assign('platformType', $agentDto['platformType']);
$smarty->assign('layoutName', $layoutName);
$smarty->assign('categoryDataArr', $categoryDataArr);
$smarty->display('pages/chapter5_3/index.tpl');
