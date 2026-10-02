<?php

use App\PearStub\PagerStub as Pager;
use App\Smarty\AppSmarty as Smarty;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/config-ketai.php';
require_once __DIR__ . '/plib/funcs.php';
require_once __DIR__ . '/plib/pager_ex.php';

/**
 * config/config.phpで定義
 * @var array<string, string> $CFG
 * @var string $siteName
 * @var string $home
 *
 * config/config-ketai.phpで設定
 * @var object $display
 */

// ----- 入力値受取・前処理 -----
// 画面幅から画像サイズを判断する
if ($display->getWidth() < 180) {
    $imageSizeGroup = '120';
} elseif ($display->getWidth() < 360) {
    $imageSizeGroup = '240';
} else {
    $imageSizeGroup = '480';
}

$pageID = 1;
if (isset($_REQUEST['pageID'])) {
    $pageID = $_REQUEST['pageID'];
}

// ----- メイン処理・データ操作 -----
// CMSデータを配列に格納
$entry_arr = get_entry_arr($CFG['CSV_FILE'], $_GET['category']);

// CMS配列中の元画像パスを大中小画像パスに置換する
array_walk($entry_arr, 'replace_entry_image', $imageSizeGroup);

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

$page = pager_ex($pager, $from, $to);

// ----- テンプレートエンジンの初期化とアサイン・描画 -----
$smarty = new Smarty();
$smarty->setConfigDir(__DIR__ . '/config/smarty');
$smarty->registerPlugin('modifier', 'file_exists', file_exists(...));
$smarty->assign('Pager', $pager);
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('entry', $entry);
$smarty->display('pages/chapter5_3/contents.tpl');
