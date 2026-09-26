<?php

/**
 * @var string $siteName
 * @var string $home
 * @var string $csv
 */

require_once 'ini.php';
use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);

// CSVデータを配列に格納
$fp = fopen($csv, 'r');
$i = 0;
$data = [];
while ($array = fgetcsv($fp, 5000, ',', escape: '')) {
    if ($_GET['category'] == $array[1]) {
        $data[$i]['id']       = $array[0];
        $data[$i]['category'] = $array[1];
        $data[$i]['title']    = $array[2];
        $data[$i]['text']     = $array[3];
        $data[$i]['time']     = $array[4];
        $data[$i]['image']    = $array[5];
        $i++;
    }
}
fclose($fp);

$smarty->assign('data', $data);
$smarty->assign('category', $_GET['category']);
$smarty->display('contents.tpl');
