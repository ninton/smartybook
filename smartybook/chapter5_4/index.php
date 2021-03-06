<?php

require_once("ini.php");
require_once("../vendor/autoload.php");

$smarty = new Smarty();
$smarty->assign("siteName", $siteName);
$smarty->assign("siteDescription", $siteDescription);
$smarty->assign("home", $home);
$smarty->assign("categories", $categories);

if (!$smarty->isCached('index.tpl')) {
    $picture = array();
    $data = array();

    // CSVデータを配列に格納
    $fp = fopen($csv, "r");
    $i = 0;
    $p = 0;

    while ($array = fgetcsv($fp, 5000, ",")) {
        if ($array[1] == "Picture") {
            $picture[$p]["id"]       = $array[0];
            $picture[$p]["category"] = $array[1];
            $picture[$p]["title"]    = $array[2];
            $picture[$p]["text"]     = $array[3];
            $picture[$p]["time"]     = $array[4];
            $picture[$p]["image"]    = $array[5];
            $p++;
        } elseif ($array[1] == "Notice") {
            $notice = $array[3];
            $smarty->assign("notice", $notice);
        } else {
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
    $smarty->assign("picture", $picture);

    //Twitter APIからのコンテンツ読み込み
    $twitterUrl =  'http://twitter.com/statuses/user_timeline/kara_d.json';
    $twitterUrl =  'kara_d.json';
    $jTwitter = file_get_contents($twitterUrl);
    $aTwitter = json_decode($jTwitter);
    $smarty->assign("aTwitter", $aTwitter);
}

//出力
$smarty->display("index.tpl");
