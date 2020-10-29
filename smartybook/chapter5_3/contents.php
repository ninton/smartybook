<?php

require_once('./ini.php');
require_once('./ketai_ini.php');

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


$pageID = 0;
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

// Pagerクラスのプロパティを拡張する
require('./plib/pager_ex.php');

$smarty = new Smarty();
$smarty->assign("Pager", $pager);
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("entry", $entry);
$smarty->display("contents.tpl");
exit();

// CSVデータを配列に格納
function get_entry_arr($i_path, $i_category)
{
    $entry_arr = array();
    $fp = fopen($i_path, "r");
    while ($arr = fgetcsv($fp, 5000, ",")) {
        if ($i_category == $arr[1]) {
            $rcd = array();
            $rcd["id"      ] = $arr[0];
            $rcd["category"] = $arr[1];
            $rcd["title"   ] = $arr[2];
            $rcd["text"    ] = $arr[3];
            $rcd["time"    ] = $arr[4];
            $rcd["image"   ] = $arr[5];

            $entry_arr[] = $rcd;
        }
    }
    fclose($fp);

    return $entry_arr;
}

// 元画像パスを大中小画像パスに置換する
function replace_entry_image(&$io_rcd, $i_key, $i_imageSizeGroup)
{
    if ($io_rcd['image']) {
        $fname = basename($io_rcd['image']);
        $io_rcd['image'] = sprintf('images/%s/%s', $i_imageSizeGroup, $fname);
    }
}
