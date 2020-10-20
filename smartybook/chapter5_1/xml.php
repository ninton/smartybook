<?php
header ("Content-Type: application/xml; charset=UTF-8");
require_once("ini.php");
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("categories", $categories);
//$smarty->assign("notice", $notice);
// CSV�f�[�^��z��Ɋi�[
$fp = fopen($csv, "r");
$i = 0;
while($array = fgetcsv($fp, 5000, ",")){
	if ($array[1] == "Notice") {
		$notice = $array[3];
		$smarty->assign("notice", $notice);
	}
    $data[$i]["id"] = $array[0];
    $data[$i]["category"] = $array[1];
    $data[$i]["title"] = $array[2];
    $data[$i]["text"] = $array[3];
    $data[$i]["time"] = $array[4];
    $data[$i]["image"] = $array[5];
    $i++;
}
fclose($fp);
//�f�[�^��smarty�̕ϐ��Ƃ��Ċi�[
$smarty->assign("data", $data);
$smarty->display("xml.tpl");
function insert_noticeText () {
	$noticeText = '<img src="./images/banner.gif" />';
	return $noticeText;
}

function insert_noticeText2 ($siteName) {
	return '<img src="./images/banner.gif" /><br />' . $siteName["siteName"];
}
?>

