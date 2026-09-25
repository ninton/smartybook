<?php

use Smarty\Smarty;
use Lib\PearStub\PagerStub as Pager;

require_once('./ini.php');
require_once('./ketai_ini.php');
require_once __DIR__ . '/plib/funcs.php';
require_once __DIR__ . '/plib/pager_ex.php';

/**
 * @var array<string, string> $CFG init.phpで設定
 * @var object $display ketai_init,phpで設定
 * @var string $siteName ini.phpで設定
 * @var string $home ini.phpで設定
 */
// 画面幅から画像サイズを判断する
if ($display->getWidth() < 180) {
    $imageSizeGroup = '120';
} elseif ($display->getWidth() < 360) {
    $imageSizeGroup = '240';
} else {
    $imageSizeGroup = '480';
}

// CMSデータを配列に格納
$entry_arr = get_entry_arr($CFG['CSV_FILE'], $_GET['category']);

// CMS配列中の元画像パスを大中小画像パスに置換する
array_walk($entry_arr, 'replace_entry_image', $imageSizeGroup);

$pageID = 1;
if (isset($_REQUEST['pageID'])) {
    $pageID = $_REQUEST['pageID'];
}
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

$smarty = new Smarty();

$smarty->registerPlugin('modifier', 'file_exists', file_exists(...));

$smarty->assign('Pager', $pager);
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('entry', $entry);
$smarty->display('contents.tpl');
