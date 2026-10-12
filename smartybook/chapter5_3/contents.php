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
 * @var array<string, string> $CFG
 * @var string $siteName
 * @var string $home
 * @var list<string> $categories
 * @var array<string, string> $iconMap
 * @var array<string, string> $layoutMap
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

$cateIcon = $iconMap[$category];

// ----- メイン処理・データ操作 -----
// CMSデータを配列に格納
$entry_arr = CsvEntryReader::fetchByCategory($CFG['CSV_FILE'], $category);

// CMS配列中の元画像パスを大中小画像パスに置換する
array_walk($entry_arr, EntryImagePathResolver::resolve(...), $imageSizeGroup);

// ページ番号の調整
if (count($entry_arr) < $pageID) {
    $pageID = count($entry_arr);
}

$params = [];
$params['perPage'] = 1;
$params['totalItems'] = count($entry_arr);
$params['currentPage'] = $pageID;
$pager = Pager::factory($params);

// 表示開始位置と終了位置
list($from, $to) = $pager->getOffsetByPageId();

$entry = [];
if ((0 < $from) && (0 < $to)) {
    list($entry) = array_slice($entry_arr, $from - 1, 1);
}

// ----- UIパーツ -----
$layoutName = $layoutMap[$agentDto['platformType']];

$pagerDto = PearPagerMapper::toDto($pager, $from, $to);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->setConfigDir(__DIR__ . '/config/smarty');
$smarty->registerPlugin('modifier', 'file_exists', file_exists(...));
$smarty->assign('Pager', $pager);
$smarty->assign('PagerDto', $pagerDto);
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('category', $category);
$smarty->assign('cate_icon', $cateIcon);
$smarty->assign('entry', $entry);
$smarty->assign('platformType', $agentDto['platformType']);
$smarty->assign('layoutName', $layoutName);
$smarty->display('pages/chapter5_3/contents.tpl');
