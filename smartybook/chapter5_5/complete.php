<?php
require_once("ini.php");
require_once("../smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("home", $home);
$smarty->assign("admin", $admin);
// 最新記事IDを取得する関数
function lastIdCheck($file){
    while($array = fgetcsv($file, 5000, ",")) {
        $lastId = $array[0];
    }
    if($lastId == ""){
        $lastId = 0;
    }
    return $lastId;
}
// 改行文字,カンマ,クォートを処理する関数
function convertNl($str){
	$str = stripslashes($str);
    $str = str_replace('"', '""', $str);
    $str = '"' . $str . '"';
    return $str;
}
//adminページ用
$smarty->assign("categories", $categories);
//認証開始
$oAuth->start();
//認証が通った際の処理
if($oAuth->getAuth()){
	if ($_POST["title"]) {
		// 記事の書き込み
		$fp = fopen("data.csv", "a+") or die("file_open_error");
		flock($fp, LOCK_EX);
		$lastId = lastIdCheck($fp);
		$id = sprintf("%04d", $lastId + 1);
		// 本文の改行文字,カンマ,ダブルクォートの処理
		$title = convertNl($_POST["title"]);
		$contents = convertNl($_POST["contents"]);
		$string = $id.",".$_POST["category"].",".$title.",".$contents.",".$_POST["date"].",".$_POST["image"]."\n";
		$check = fwrite($fp, $string);
		if($check == FALSE){
			$smarty->assign("flag", "FALSE");
		}else if(is_int($check)){
			$smarty->assign("flag", "TRUE");
		}else{
			$smarty->assign("flag", "FALSE");
		}
		flock($fp, LOCK_UN);
		fclose($fp);
		//出力
		$smarty->display("complete.tpl");
	} else {
		$smarty->display("admin.tpl");
	}
}

?>