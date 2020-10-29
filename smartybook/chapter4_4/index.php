<?php

//CSVファイルパス
$csv = "data.csv";
require_once('../smarty/libs/Smarty.class.php');
$smarty = new Smarty();
// CSVデータを配列に格納
$fp = fopen($csv, "r");
$i = 0;
while ($array = fgetcsv($fp, 5000, ",")) {
    $data[$i]["id"]       = $array[0];
    $data[$i]["category"] = $array[1];
    $data[$i]["title"]    = $array[2];
    $data[$i]["time"]     = $array[3];
    $data[$i]["author"]   = $array[4];
    $i++;
}
fclose($fp);
$smarty->assign('data', $data);
$smarty->display('index.tpl');
