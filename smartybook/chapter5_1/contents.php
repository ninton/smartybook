<?php

// phpcs:disable PSR1.Files.SideEffects

require_once("ini.php");
require_once("../vendor/autoload.php");
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("categories", $categories);
//$smarty->assign("notice", $notice);
// CSVデータを配列に格納
$fp = fopen($csv, "r");
$i = 0;
while ($array = fgetcsv($fp, 5000, ",")) {
    if ($array[1] == "Notice") {
        $notice = $array[3];
        $smarty->assign("notice", $notice);
    }
    if ($_GET["category"] == $array[1]) {
        $data[$i]["id"]       = $array[0];
        $data[$i]["category"] = $array[1];
        $data[$i]["title"]    = $array[2];
        $data[$i]["text"]     = $array[3];
        $data[$i]["time"]     = $array[4];
        $data[$i]["image"]    = $array[5];
        $i++;
    }
}
fclose($fp);
//データをsmartyの変数として格納
$smarty->assign("data", $data);
$smarty->assign("category", $_GET["category"]);
//出力
$smarty->display("contents.tpl");
function insert_noticeText()
{
    $noticeText = '<img src="./images/banner.gif" />';
    return $noticeText;
}

function smarty_insert_noticeText2($siteName)
{
    return '<img src="./images/banner.gif" /><br />' . $siteName["siteName"];
}
