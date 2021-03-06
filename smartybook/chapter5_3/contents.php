<?php

require_once('./ini.php');
require_once('./ketai_ini.php');
require_once __DIR__ . '/plib/funcs.php';
require_once __DIR__ . '/plib/pager_ex.php';

/**
 * @var $CFG init.phpで設定
 * @var $display ketai_init,phpで設定
 */
// 画面幅から画像サイズを判断する
if ($display->getWidth() < 180) {
    $imageSizeGroup = "120";
} elseif ($display->getWidth() < 360) {
    $imageSizeGroup = "240";
} else {
    $imageSizeGroup = "480";
}

// CMSデータを配列に格納
$entry_arr = get_entry_arr($CFG['CSV_FILE'], $_GET["category"]);

// CMS配列中の元画像パスを大中小画像パスに置換する
array_walk($entry_arr, 'replace_entry_image', $imageSizeGroup);

$params = array();
$params['perPage'] = 1;
$params['totalItems'] = count($entry_arr);
$pager = Pager::factory($params);


$pageID = 1;
if (isset($_REQUEST['pageID'])) {
    $pageID = $_REQUEST['pageID'];
}
// ページ番号の調整
if ($pager->numPages() < $pageID) {
    $pageID = $pager->numPages();
}
// 表示開始位置と終了位置
list($from, $to) = $pager->getOffsetByPageId($pageID);

$entry = array();
if ((0 < $from) && (0 < $to)) {
    list($entry) = array_slice($entry_arr, $from - 1, 1);
}

$page = pager_ex($pager, $from, $to);

$smarty = new Smarty();
$smarty->assign("Pager", $pager);
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("entry", $entry);
$smarty->display("contents.tpl");
