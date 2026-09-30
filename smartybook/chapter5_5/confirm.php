<?php

use App\Smarty\AppSmarty as Smarty;
use Lib\PearStub\AuthStub as Auth;

require_once dirname(__DIR__, 2) . '/bootstrap/app.php';
require_once __DIR__ . '/ini.php';
/**
 * ini.phpで定義されている変数
 * @var string $siteName
 * @var string $home
 * @var string $admin
 * @var string[] $categories
 * @var Auth $oAuth
 * @var string $imageDir
 */

// 認証開始
$oAuth->start();
if (!$oAuth->getAuth()) {
    // 認証失敗
    // ini.php の displayLogin 関数が呼ばれるので、ここでは何も出力しない
    return;
}

// テンプレートエンジンの初期化とアサイン・描画
$smarty = new Smarty();
$smarty->assign('siteName', $siteName);
$smarty->assign('home', $home);
$smarty->assign('admin', $admin);
//adminページ用
$smarty->assign('categories', $categories);

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
    $smarty->display('pages/chapter5_5/confirm.tpl');
} else {
    $smarty->display('pages/chapter5_5/admin.tpl');
}
