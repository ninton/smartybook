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

/**
 * @note CD-ROM収録コードの仕様に合わせて `if ($_POST['title']) {` を残しているが、
 * 他の章ではこの判別をしていないので、削除しても問題ない。
 */
if ($_POST['title']) {
    // ----- メイン処理・データ操作 -----
    // 画像のアップロード
    if (!is_dir($imageDir)) {
        mkdir($imageDir);
    }
    if (isset($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        copy($_FILES['image']['tmp_name'], $imageDir . $_FILES['image']['name']);
        $imageFile = $imageDir . $_FILES['image']['name'];
    } else {
        $imageFile = '';
    }

    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('siteName', $siteName);
    $smarty->assign('home', $home);
    $smarty->assign('admin', $admin);
    $smarty->assign('category', $_POST['category']);
    $smarty->assign('title', stripslashes($_POST['title']));
    $smarty->assign('contents', stripslashes($_POST['contents']));
    $smarty->assign('date', $_POST['date']);
    $smarty->assign('imageFile', $imageFile);
    $smarty->display('pages/chapter5_5/confirm.tpl');
} else {
    // ----- テンプレートエンジンの初期化とアサイン・描画 -----
    $smarty = new Smarty();
    $smarty->assign('siteName', $siteName);
    $smarty->assign('home', $home);
    $smarty->assign('admin', $admin);
    $smarty->assign('categories', $categories);
    $smarty->display('pages/chapter5_5/admin.tpl');
}
