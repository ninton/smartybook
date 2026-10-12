<?php

use App\PearStub\NetUserAgentMobileCommonStub;
use App\PearStub\PagerStub as Pager;
use App\Smarty\AppSmarty as Smarty;
use SmartyBook\chapter5_3\src\CsvEntryReader;
use SmartyBook\chapter5_3\src\EntryImagePathResolver;
use SmartyBook\chapter5_3\src\KetaiSetUp;
use SmartyBook\chapter5_3\src\NetUserAgentMobileMapper;
use SmartyBook\chapter5_3\src\PearPagerMapper;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';

/**
 * config/config.phpで定義
 * @var string $siteName
 * @var string $home
 * @var string $csvFilePath
 * @var list<string> $categories
 * @var array<string, string> $categoryToIconMap
 * @var array<string, string> $platformTypeToLayoutMap
 */

// ----- 入力値受取・前処理 -----
$agentDto = NetUserAgentMobileMapper::toDto(new NetUserAgentMobileCommonStub());
KetaiSetUp::contentType($agentDto['rawCarrier']);
KetaiSetUp::outputHandler($agentDto['platformType']);

$imageSizeGroup = $agentDto['imageSizeGroup'];

$pageID = 1;
if (isset($_REQUEST['pageID'])) {
    $pageID = $_REQUEST['pageID'];
}

$category = $_GET['category'] ?? '';

// 文字列であることを確認しつつ、ホワイトリストに含まれているかチェック
if (!is_string($category) || !in_array($category, $categories, true)) {
    http_response_code(404);
    exit;
}

$categoryIcon = $categoryToIconMap[$category];

// ----- メイン処理・データ操作 -----
// CMSデータを配列に格納
$entryArr = CsvEntryReader::fetchByCategory($csvFilePath, $category);

// CMS配列中の元画像パスを大中小画像パスに置換する
array_walk($entryArr, EntryImagePathResolver::resolve(...), $imageSizeGroup);

// ページ番号の調整
if (count($entryArr) < $pageID) {
    $pageID = count($entryArr);
}

$params = [];
$params['perPage'] = 1;
$params['totalItems'] = count($entryArr);
$params['currentPage'] = $pageID;
$pager = Pager::factory($params);

$pagerDto = PearPagerMapper::toDto($pager);

$entry = [];
if ((0 < $pagerDto->offsetFrom) && (0 < $pagerDto->offsetTo)) {
    list($entry) = array_slice($entryArr, $pagerDto->offsetFrom - 1, 1);
}

// ----- UIパーツ -----
$layoutName = $platformTypeToLayoutMap[$agentDto['platformType']];

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->setConfigDir(__DIR__ . '/config/smarty');
$smarty->registerPlugin('modifier', 'file_exists', file_exists(...));
$smarty->assign('pagerDto', $pagerDto);
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('category', $category);
$smarty->assign('categoryIcon', $categoryIcon);
$smarty->assign('entry', $entry);
$smarty->assign('platformType', $agentDto['platformType']);
$smarty->assign('layoutName', $layoutName);
$smarty->display('pages/chapter5_3/contents.tpl');
