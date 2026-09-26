<?php

require_once 'ini.php';
use Lib\PearStub\AuthStub as Auth;
use Smarty\Smarty;

require_once __DIR__ . '/../../vendor/autoload.php';

/** @var string $siteName */
/** @var string $home */
/** @var string $admin */
/** @var string[] $categories */
/** @var Auth $oAuth */
/** @var string $imageDir */

$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
//adminページ用
$smarty->assign('categories', $categories);
//認証開始
$oAuth->start();
//認証が通った際の処理
if ($oAuth->getAuth()) {
    if ($_POST['title']) {
        // 画像のアップロード
        if (!is_dir($imageDir)) {
            mkdir($imageDir);
        }
        if (isset($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            copy($_FILES['image']['tmp_name'], $imageDir . $_FILES['image']['name']);
            $smarty->assign('imageFile', $imageDir . $_FILES['image']['name']);
        } else {
            $smarty->assign('imageFile', '');
        }
        $smarty->assign('category', $_POST['category']);
        $smarty->assign('title', stripslashes($_POST['title']));
        $smarty->assign('contents', stripslashes($_POST['contents']));
        $smarty->assign('date', $_POST['date']);
        //出力
        $smarty->display('confirm.tpl');
    } else {
        $smarty->display('admin.tpl');
    }
}
