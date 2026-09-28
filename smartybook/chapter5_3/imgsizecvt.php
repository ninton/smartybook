<?php

use App\Smarty\AppSmarty as Smarty;

require_once __DIR__ . '/ini.php';
require_once __DIR__  . '/plib/imgsizecvt_funcs.php';

switch (strtolower($_SERVER['REQUEST_METHOD'])) {
    case 'post':
        // ----- メイン処理・データ操作 -----
        proc_image_resize(basename($_POST['fname']));
        $url = get_current_url();
        header("Location: $url");
        break;

    default:
        // ----- メイン処理・データ操作 -----
        $rcd_arr = proc_image_list();

        // ----- テンプレートエンジンの初期化とアサイン・描画 -----
        $smarty = new Smarty();
        $smarty->assign('rcd_arr', $rcd_arr);
        $smarty->display('pages/chapter5_3/imgsizecvt.tpl');
        break;
}
